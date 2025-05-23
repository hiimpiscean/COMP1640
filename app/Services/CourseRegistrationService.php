<?php

namespace App\Services;

use App\Models\CourseRegistration;
use App\Models\User;
use App\Models\Course;
use App\Repository\CourseRegistrationRepos;
use Illuminate\Support\Facades\Mail;
use App\Mail\CourseRegistrationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class CourseRegistrationService
{
    /**
     * Create a new course registration and notify staff
     *
     * @param int $studentId
     * @param int $courseId
     * @return stdClass
     * @throws \Exception
     */
    public function createRegistration($studentId, $courseId)
    {
        try {
            DB::beginTransaction();
            
            // Kiểm tra xem học viên tồn tại không
            $student = \App\Repository\CustomerRepos::getCustomerById($studentId);
            if (!$student) {
                throw new \Exception('Cannot find student information.');
            }
            
            // Kiểm tra khóa học tồn tại không - sử dụng bảng timetable thay vì product
            // Lỗi là do courseId phải tham chiếu đến timetable.id chứ không phải product.id_p
            $timetableEntry = $this->getTimetableById($courseId);
            if (!$timetableEntry) {
                throw new \Exception('Cannot find timetable entry with ID: ' . $courseId . '. The course may not be scheduled yet.');
            }
            
            // Lấy thông tin khóa học từ ID
            $course = \App\Repository\ProductRepos::getProductById($timetableEntry->course_id ?? $courseId);

            if (!$course) {
                throw new \Exception('Cannot find course information.');
            }
            
            // Lấy ID của product để kiểm tra đăng ký
            $productId = isset($course[0]) ? $course[0]->id_p : (isset($course->id_p) ? $course->id_p : null);
            
            if (!$productId) {
                    throw new \Exception('Cannot determine course ID.');
            }
            
            // Kiểm tra xem đã đăng ký khóa học này chưa - sử dụng productId thay vì courseId
            $existingRegistrations = CourseRegistrationRepos::getByStudentAndCourse($studentId, $productId);
            
            // Không còn liên kết trực tiếp giữa bảng registration và student qua id
            // Kiểm tra thủ công bằng cách duyệt các đăng ký
            $alreadyRegistered = false;
            $registrationStatus = null;
            foreach ($existingRegistrations as $reg) {
                // Kiểm tra xem học sinh đã đăng ký khóa học này chưa
                $alreadyRegistered = true;
                $registrationStatus = $reg->status;
                break;
            }
            
            // Thay vì chặn việc đăng ký lại, chỉ ghi log và tiếp tục
            if ($alreadyRegistered) {
                Log::info("Student ID: $studentId is trying to register again for course ID: $productId - Current status: $registrationStatus");
                
                // Nếu đăng ký cũ đã được phê duyệt, thông báo cho người dùng
                if ($registrationStatus === 'approved') {
                    throw new \Exception('You have already been approved for this course. No need to register again.');
                }
                
                // Nếu đăng ký cũ đang chờ xử lý, thông báo cho người dùng
                if ($registrationStatus === 'pending') {
                    throw new \Exception('You have already registered for this course and are waiting for approval. Please wait for a response from the staff.');
                }
                
                // Nếu đăng ký cũ đã bị từ chối, cho phép đăng ký lại
                // Không làm gì ở đây để tiếp tục quy trình đăng ký
            }
            
            // Trong database course, cột chứa ID của teacher có thể là teacher_id hoặc id_t
            // Kiểm tra course có phần tử nào là id_t không
            if (isset($course->id_t)) {
                $teacherId = $course->id_t;
            } elseif (isset($course->teacher_id)) {
                $teacherId = $course->teacher_id;
            } else {
                // Lấy ID của một giáo viên có sẵn từ bảng teacher
                $firstTeacher = \App\Repository\TeacherRepos::getAllTeacher()[0] ?? null;
                $teacherId = $firstTeacher ? $firstTeacher->id_t : null;
                
                if (!$teacherId) {
                    throw new \Exception('Cannot find any teacher in the system. Cannot create course registration.');
                }
            }
            
            // Verify that teacher exists in the database
            $teacher = \App\Repository\TeacherRepos::getTeacherById($teacherId);
            if (!$teacher) {
                throw new \Exception('Teacher with ID ' . $teacherId . ' does not exist in the system.');
            }
            
            // Create registration object
            $registration = new stdClass();
            $registration->teacher_id = $teacherId;
            
            // LƯU Ý: Đảm bảo sử dụng ID của product (id_p) thay vì ID của timetable
            // vì ràng buộc khóa ngoại yêu cầu course_id phải tồn tại trong bảng product
            if (isset($course[0])) {
                // Nếu là mảng kết quả từ repository
                $registration->course_id = $course[0]->id_p;
            } elseif (isset($course->id_p)) {
                // Nếu là đối tượng course
                $registration->course_id = $course->id_p;
            } else {
                // Fallback nếu không thể xác định ID
                throw new \Exception('Cannot determine course ID. Ensure the course exists in the system.');
            }
            
            $registration->status = 'pending';
            $registration->created_at = now();
            $registration->description = 'Student ID: ' . $studentId . ' - ' . $student->fullname_c;
            
            // Use repository to insert the registration
            $registrationId = CourseRegistrationRepos::insert($registration);
            
            if ($registrationId === -1) {
                throw new \Exception('Failed to create registration');
            }
            
            // Get complete registration data for email
            $registrationData = CourseRegistrationRepos::getById($registrationId)[0] ?? null;
            
            if (!$registrationData) {
                throw new \Exception('Failed to retrieve registration data');
            }
            
            // Prepare data for email
            $emailData = new stdClass();
            $emailData->id = $registrationId;
            $emailData->student = $student;
            $emailData->teacher = $teacherId ? \App\Repository\TeacherRepos::getTeacherById($teacherId) : new stdClass();
            $emailData->course = $course;
            $emailData->status = 'pending';
            $emailData->created_at = $registrationData->created_at;
            
            // Get all staff members
            $staffMembers = \App\Repository\StaffRepos::getAllStaff();
            
            // Kiểm tra có nhân viên không trước khi gửi email
            if (count($staffMembers) > 0) {
                // Send email to each staff member
                foreach ($staffMembers as $staff) {
                    try {
                        Mail::to($staff->email)
                            ->send(new CourseRegistrationMail($emailData, 'new_registration_to_staff'));
                    } catch (\Exception $e) {
                        // Log lỗi nhưng không throw exception để không ảnh hưởng đến quá trình đăng ký
                        Log::error('Không thể gửi email đến nhân viên: ' . $staff->email . '. Lỗi: ' . $e->getMessage());
                    }
                }
            } else {
                Log::warning('Không tìm thấy nhân viên nào để gửi thông báo đăng ký khóa học.');
            }
            
            DB::commit();
            return $registrationData;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration creation failed: ' . $e->getMessage(), [
                'studentId' => $studentId,
                'courseId' => $courseId,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    
    /**
     * Approve a registration and notify student and teacher
     *
     * @param int $registrationId
     * @return stdClass
     * @throws \Exception
     */
    public function approveRegistration($registrationId)
    {
        try {
            DB::beginTransaction();
            
            // Get registration data using repository
            $registrationData = CourseRegistrationRepos::getById($registrationId)[0] ?? null;
            
            if (!$registrationData) {
                throw new \Exception('Cannot find registration information.');
            }
            
            // Kiểm tra trạng thái hiện tại
            if ($registrationData->status === 'approved') {
                throw new \Exception('This registration has already been approved before.');
            }
            
            if ($registrationData->status === 'rejected') {
                throw new \Exception('This registration has already been rejected before.');
            }
            
            // Update status to approved
            $registrationData->status = 'approved';
            $result = CourseRegistrationRepos::update($registrationData);
            
            if (!$result) {
                throw new \Exception('Cannot update registration status.');
            }
            
            // Trích xuất ID học viên từ description
            $studentId = null;
            $matches = [];
            if (preg_match('/Student ID: (\d+)/', $registrationData->description, $matches)) {
                $studentId = $matches[1];
            }
            
            if (!$studentId) {
                throw new \Exception('Cannot determine student ID from registration.');
            }
            
            // Get related data for email
            $student = \App\Repository\CustomerRepos::getCustomerById($studentId);
            if (!$student) {
                throw new \Exception('Cannot find student information with ID: ' . $studentId);
            }
            
            $teacher = $registrationData->teacher_id ? \App\Repository\TeacherRepos::getTeacherById($registrationData->teacher_id) : null;
            
            // Lấy thông tin khóa học
            $course = null;
            try {
                // Thử lấy từ timetable trước
                $timetable = $this->getTimetableById($registrationData->course_id);
                $courseId = $timetable ? $timetable->course_id : $registrationData->course_id;
                $courseResult = \App\Repository\ProductRepos::getProductById($courseId);
                
                if (!empty($courseResult)) {
                    if (is_array($courseResult)) {
                        $course = $courseResult[0];
                    } else {
                        $course = $courseResult;
                    }
                } else {
                    // Nếu không tìm thấy, tạo một đối tượng khóa học đơn giản
                    $course = new stdClass();
                    $course->name_p = "Khóa học #" . $registrationData->course_id;
                    Log::warning('Không tìm thấy thông tin khóa học ID: ' . $registrationData->course_id);
                }
            } catch (\Exception $e) {
                Log::error('Lỗi khi lấy thông tin khóa học: ' . $e->getMessage());
                $course = new stdClass();
                $course->name_p = "Khóa học #" . $registrationData->course_id;
            }
            
            // Prepare data for email
            $emailData = new stdClass();
            $emailData->id = $registrationId;
            $emailData->student = $student;
            $emailData->teacher = $teacher ? $teacher : new stdClass();
            $emailData->course = $course;
            $emailData->status = 'approved';
            $emailData->created_at = $registrationData->created_at;
            
            // Send email to student
            try {
                Mail::to($student->email)
                    ->send(new CourseRegistrationMail($emailData, 'approval_to_student'));
            } catch (\Exception $e) {
                // Log lỗi nhưng không dừng quy trình
                Log::error('Không thể gửi email thông báo phê duyệt cho học viên: ' . $e->getMessage());
            }
            
            // Send email to teacher if available
            if ($teacher) {
                try {
                    Mail::to($teacher->email)
                        ->send(new CourseRegistrationMail($emailData, 'approval_to_teacher'));
                } catch (\Exception $e) {
                    // Log lỗi nhưng không dừng quy trình
                    Log::error('Không thể gửi email thông báo phê duyệt cho giáo viên: ' . $e->getMessage());
                }
            }
            
            DB::commit();
            
            // Gửi thông báo đến admin
            $this->notifyAdminAboutRegistrationChange($registrationId, 'approved');
            
            return $registrationData;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration approval failed: ' . $e->getMessage(), [
                'registrationId' => $registrationId,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    
    /**
     * Reject a registration and notify the student
     *
     * @param int $registrationId
     * @return stdClass
     * @throws \Exception
     */
    public function rejectRegistration($registrationId)
    {
        try {
            DB::beginTransaction();
            
            // Get registration data using repository
            $registrationData = CourseRegistrationRepos::getById($registrationId)[0] ?? null;
            
            if (!$registrationData) {
                throw new \Exception('Cannot find registration information.');
            }
            
            // Kiểm tra trạng thái hiện tại
            if ($registrationData->status === 'approved') {
                throw new \Exception('This registration has already been approved before, cannot reject.');
            }
            
            if ($registrationData->status === 'rejected') {
                throw new \Exception('This registration has already been rejected before, cannot reject.');
            }
            
            // Update status to rejected
            $registrationData->status = 'rejected';
            $result = CourseRegistrationRepos::update($registrationData);
            
            if (!$result) {
                throw new \Exception('Cannot update registration status.');
            }
            
            // Trích xuất ID học viên từ description
            $studentId = null;
            $matches = [];
            if (preg_match('/Student ID: (\d+)/', $registrationData->description, $matches)) {
                $studentId = $matches[1];
            }
            
            if (!$studentId) {
                throw new \Exception('Cannot determine student ID from registration.');
            }
            
            // Get related data for email
            $student = \App\Repository\CustomerRepos::getCustomerById($studentId);
            if (!$student) {
                throw new \Exception('Cannot find student information with ID: ' . $studentId);
            }
            
            // Lấy thông tin khóa học
            $course = null;
            try {
                // Thử lấy từ timetable trước
                $timetable = $this->getTimetableById($registrationData->course_id);
                $courseId = $timetable ? $timetable->course_id : $registrationData->course_id;
                $courseResult = \App\Repository\ProductRepos::getProductById($courseId);
                
                if (!empty($courseResult)) {
                    if (is_array($courseResult)) {
                        $course = $courseResult[0];
                    } else {
                        $course = $courseResult;
                    }
                } else {
                    // Nếu không tìm thấy, tạo một đối tượng khóa học đơn giản
                    $course = new stdClass();
                    $course->name_p = "Course #" . $registrationData->course_id;
                    Log::warning('Cannot find course information with ID: ' . $registrationData->course_id);
                }
            } catch (\Exception $e) {
                Log::error('Error getting course information: ' . $e->getMessage());
                $course = new stdClass();
                $course->name_p = "Course #" . $registrationData->course_id;
            }
            
            // Prepare data for email
            $emailData = new stdClass();
            $emailData->id = $registrationId;
            $emailData->student = $student;
            $emailData->course = $course;
            $emailData->status = 'rejected';
            $emailData->created_at = $registrationData->created_at;
            
            // Send email to student
            try {
                Mail::to($student->email)
                    ->send(new CourseRegistrationMail($emailData, 'rejection_to_student'));
            } catch (\Exception $e) {
                // Log lỗi nhưng không dừng quy trình
                Log::error('Không thể gửi email thông báo từ chối cho học viên: ' . $e->getMessage());
            }
            
            DB::commit();
            
            // Gửi thông báo đến admin
            $this->notifyAdminAboutRegistrationChange($registrationId, 'rejected');
            
            return $registrationData;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration rejection failed: ' . $e->getMessage(), [
                'registrationId' => $registrationId,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    
    /**
     * Check registration status and send notifications if needed
     *
     * @param int $courseId
     * @return void
     */
    public function checkAndNotifyCourseStatus($courseId)
    {
        try {
            // Get all registrations for this course
            $registrations = CourseRegistrationRepos::getByCourseId($courseId);
            
            foreach ($registrations as $registration) {
                // Check if registration has changed status recently
                if ($registration->status === 'approved' && !$registration->notified_approval) {
                    // Send notification for approval
                    $this->sendStatusNotification($registration->id, 'approved');
                    
                    // Mark as notified
                    $registration->notified_approval = true;
                    CourseRegistrationRepos::update($registration);
                }
                
                if ($registration->status === 'rejected' && !$registration->notified_rejection) {
                    // Send notification for rejection
                    $this->sendStatusNotification($registration->id, 'rejected');
                    
                    // Mark as notified
                    $registration->notified_rejection = true;
                    CourseRegistrationRepos::update($registration);
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to check and notify course status: ' . $e->getMessage());
        }
    }
    
    /**
     * Send status notification based on registration status
     *
     * @param int $registrationId
     * @param string $status
     * @return void
     */
    private function sendStatusNotification($registrationId, $status)
    {
        try {
            // Get registration data
            $registrationData = CourseRegistrationRepos::getById($registrationId)[0] ?? null;
            
            if (!$registrationData) {
                throw new \Exception('Registration not found');
            }
            
            // Trích xuất ID học viên từ description
            $studentId = null;
            $matches = [];
            if (preg_match('/Student ID: (\d+)/', $registrationData->description, $matches)) {
                $studentId = $matches[1];
            }
            
            if (!$studentId) {
                throw new \Exception('Cannot determine student ID from registration.');
            }
            
            // Get related data
            $student = \App\Repository\CustomerRepos::getCustomerById($studentId);
            if (!$student) {
                throw new \Exception('Cannot find student information with ID: ' . $studentId);
            }
            
            $teacher = $registrationData->teacher_id ? \App\Repository\TeacherRepos::getTeacherById($registrationData->teacher_id) : null;
            
            // Lấy thông tin khóa học từ timetable
            $timetable = $this->getTimetableById($registrationData->course_id);
            $courseId = $timetable ? $timetable->course_id : $registrationData->course_id;
            $course = \App\Repository\ProductRepos::getProductById($courseId);
            
            if (!$course) {
                    Log::warning('Cannot find course information with ID: ' . $registrationData->course_id);
                // Tạo dữ liệu đơn giản cho khóa học
                $tempCourse = new \stdClass();
                $tempCourse->name_p = "Khóa học #" . $registrationData->course_id;
                $tempCourse->title = "Khóa học #" . $registrationData->course_id;
                $course = $tempCourse;
            }
            
            // Prepare email data
            $emailData = new \stdClass();
            $emailData->id = $registrationId;
            $emailData->student = $student;
            $emailData->teacher = $teacher ? $teacher : new stdClass();
            
            // Đảm bảo thông tin khóa học được gán đúng định dạng và có đầy đủ thông tin
            if (is_array($course)) {
                $emailData->course = $course[0];
                if (!isset($emailData->course->title)) {
                    $emailData->course->title = $emailData->course->name_p;
                }
            } else {
                $emailData->course = $course;
                if (!isset($emailData->course->title)) {
                    $emailData->course->title = $emailData->course->name_p;
                }
            }
            
            $emailData->status = $status;
            $emailData->created_at = $registrationData->created_at;
            
            // Send appropriate notification based on status
            if ($status === 'approved') {
                Mail::to($student->email)
                    ->send(new CourseRegistrationMail($emailData, 'approval_to_student'));
                
                if ($teacher) {
                    Mail::to($teacher->email)
                        ->send(new CourseRegistrationMail($emailData, 'approval_to_teacher'));
                }
            } elseif ($status === 'rejected') {
                Mail::to($student->email)
                    ->send(new CourseRegistrationMail($emailData, 'rejection_to_student'));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send status notification: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Get timetable entry by ID
     * 
     * @param int $id
     * @return object|null
     */
    private function getTimetableById($id)
    {
        try {
            // Truy vấn trực tiếp từ bảng timetable
            $sql = "SELECT * FROM timetable WHERE id = ?";
            $result = DB::select($sql, [$id]);
            
            // Nếu không tìm thấy trong timetable, có thể đây là ID của khóa học
            if (empty($result)) {
                // Thử lấy thông tin từ bảng product
                $productResults = \App\Repository\ProductRepos::getProductById($id);
                if (!empty($productResults)) {
                    $product = $productResults[0];
                    // Tạo một object giả lập timetable để tương thích
                    $timetable = new \stdClass();
                    $timetable->id = $id;
                    $timetable->course_id = $id;
                    return $timetable;
                }
                return null;
            }
            
            return $result ? $result[0] : null;
        } catch (\Exception $e) {
            Log::error('Failed to get timetable entry: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all course registrations with complete data
     *
     * @return array
     */
    public function getAllPendingRegistrations()
    {
        try {
            // Lấy tất cả đăng ký, không chỉ pending
            $allRegistrations = CourseRegistrationRepos::getAll();
            
            // Chuẩn bị dữ liệu hoàn chỉnh với thông tin liên quan
            $result = [];
            
            foreach ($allRegistrations as $registration) {
                // Trích xuất ID học viên từ description
                $studentId = null;
                $matches = [];
                if (preg_match('/Student ID: (\d+)/', $registration->description, $matches)) {
                    $studentId = $matches[1];
                }
                
                if (!$studentId) {
                    Log::warning('Cannot determine student ID from registration ID: ' . $registration->id);
                    continue; // Bỏ qua đăng ký này nếu không tìm thấy ID học viên
                }
                
                // Lấy thông tin học viên
                $student = \App\Repository\CustomerRepos::getCustomerById($studentId);
                
                if (!$student) {
                    Log::warning('Cannot find student with ID: ' . $studentId . ' for registration ID: ' . $registration->id);
                    continue; // Bỏ qua đăng ký này nếu không tìm thấy học viên
                }
                
                // Lấy thông tin giáo viên
                $teacher = $registration->teacher_id ? \App\Repository\TeacherRepos::getTeacherById($registration->teacher_id) : null;
                
                // Lấy thông tin khóa học
                $course = null;
                
                try {
                    // Thử lấy từ timetable trước
                    $timetable = $this->getTimetableById($registration->course_id);
                    
                    if ($timetable && isset($timetable->course_id)) {
                        $courseResults = \App\Repository\ProductRepos::getProductById($timetable->course_id);
                        if (!empty($courseResults)) {
                            $course = $courseResults[0];
                        }
                    }
                    
                    // Nếu không tìm thấy, thử lấy trực tiếp từ bảng product
                    if (!$course) {
                        $courseResults = \App\Repository\ProductRepos::getProductById($registration->course_id);
                        if (!empty($courseResults)) {
                            $course = $courseResults[0];
                        }
                    }
                    
                    // Nếu vẫn không tìm thấy, tạo một object khóa học đơn giản
                    if (!$course) {
                        $course = new \stdClass();
                        $course->name_p = "Khóa học #" . $registration->course_id;
                        Log::warning('Cannot find course information with ID: ' . $registration->course_id);
                    }
                } catch (\Exception $e) {
                    Log::error('Error getting course information: ' . $e->getMessage());
                    $course = new \stdClass();
                    $course->name_p = "Course #" . $registration->course_id;
                }
                
                // Tạo đối tượng dữ liệu hoàn chỉnh
                $registrationData = new \stdClass();
                $registrationData->id = $registration->id;
                
                // Cấu trúc đối tượng student theo template
                $studentObj = new \stdClass();
                $studentObj->fullname_c = $student->fullname_c ?? 'N/A';
                $studentObj->email = $student->email ?? 'N/A';
                $registrationData->student = $studentObj;
                
                // Cấu trúc đối tượng teacher theo template
                $teacherObj = new \stdClass();
                $teacherObj->fullname_t = $teacher->fullname_t ?? 'Teacher 1';
                $registrationData->teacher = $teacherObj;
                
                // Cấu trúc đối tượng course theo template
                $courseObj = new \stdClass();
                // Kiểm tra và gán tên khóa học từ đối tượng khóa học đã lấy được
                if (isset($course->name_p)) {
                    $courseObj->name_p = $course->name_p;
                } elseif (is_array($course) && isset($course[0]->name_p)) {
                    $courseObj->name_p = $course[0]->name_p;
                } else {
                    Log::warning('Cannot get course name for registration ID: ' . $registration->id);
                    $courseObj->name_p = 'Course #' . $registration->course_id;
                }
                $registrationData->course = $courseObj;
                
                $registrationData->status = $registration->status;
                $registrationData->created_at = $registration->created_at;
                
                $result[] = $registrationData;
            }
            
            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to get course registrations: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }

    /**
     * Send notification to admin about registration status change
     *
     * @param int $registrationId
     * @param string $status
     * @return void
     */
    private function notifyAdminAboutRegistrationChange($registrationId, $status)
    {
        try {
            // Get registration data
            $registrationData = CourseRegistrationRepos::getById($registrationId)[0] ?? null;
            
            if (!$registrationData) {
                Log::error('Cannot send notification to admin: Cannot find registration information.', [
                    'registrationId' => $registrationId
                ]);
                return;
            }
            
            // Get admin users
            $admins = User::where('role', 'admin')->get();
            
            if ($admins->count() == 0) {
                Log::info('No admin found to send notification.');
                return;
            }
            
            // Trích xuất ID học viên từ description
            $studentId = null;
            $matches = [];
            if (preg_match('/Student ID: (\d+)/', $registrationData->description, $matches)) {
                $studentId = $matches[1];
            }
            
            // Get related data
            $student = $studentId ? \App\Repository\CustomerRepos::getCustomerById($studentId) : null;
            $teacher = $registrationData->teacher_id ? \App\Repository\TeacherRepos::getTeacherById($registrationData->teacher_id) : null;
            
            // Lấy thông tin khóa học
            $course = null;
            try {
                // Thử lấy từ timetable trước
                $timetable = $this->getTimetableById($registrationData->course_id);
                $courseId = $timetable ? $timetable->course_id : $registrationData->course_id;
                $courseResult = \App\Repository\ProductRepos::getProductById($courseId);
                
                if (!empty($courseResult)) {
                    if (is_array($courseResult)) {
                        $course = $courseResult[0];
                    } else {
                        $course = $courseResult;
                    }
                } else {
                    // Nếu không tìm thấy, tạo một đối tượng khóa học đơn giản
                    $course = new stdClass();
                    $course->name_p = "Khóa học #" . $registrationData->course_id;
                    Log::warning('Cannot find course information with ID: ' . $registrationData->course_id);
                }
            } catch (\Exception $e) {
                Log::error('Error getting course information: ' . $e->getMessage());
                $course = new stdClass();
                $course->name_p = "Course #" . $registrationData->course_id;
            }
            
            // Prepare email data
            $emailData = new stdClass();
            $emailData->id = $registrationId;
            $emailData->student = $student ?? new stdClass();
            $emailData->teacher = $teacher ?? new stdClass();
            $emailData->course = $course;
            $emailData->status = $status;
            $emailData->created_at = $registrationData->created_at;
            
            // Send email to each admin
            foreach ($admins as $admin) {
                try {
                    // Sử dụng template mặc định cho admin
                    Mail::to($admin->email)
                        ->send(new CourseRegistrationMail($emailData, 'default'));
                } catch (\Exception $e) {
                    Log::error('Cannot send email notification to admin: ' . $admin->email . '. Error: ' . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            Log::error('Error sending admin notification: ' . $e->getMessage(), [
                'registrationId' => $registrationId,
                'status' => $status,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Search pending registrations by student name or course name
     *
     * @param string $searchTerm
     * @return array
     */
    public function searchPendingRegistrations($searchTerm)
    {
        try {
            // Get all registrations
            $allRegistrations = $this->getAllPendingRegistrations();
            
            // If no search term, return all registrations
            if (empty($searchTerm)) {
                return $allRegistrations;
            }
            
            // Filter registrations by student name or course name
            $searchTerm = strtolower(trim($searchTerm));
            
            $filteredRegistrations = array_filter($allRegistrations, function($registration) use ($searchTerm) {
                // Search in student name
                if (isset($registration->student->fullname_c) && 
                    str_contains(strtolower($registration->student->fullname_c), $searchTerm)) {
                    return true;
                }
                
                // Search in course name
                if (isset($registration->course->name_p) && 
                    str_contains(strtolower($registration->course->name_p), $searchTerm)) {
                    return true;
                }
                
                // Search in student email
                if (isset($registration->student->email) && 
                    str_contains(strtolower($registration->student->email), $searchTerm)) {
                    return true;
                }
                
                return false;
            });
            
            return array_values($filteredRegistrations); // Reset array keys
        } catch (\Exception $e) {
            Log::error('Failed to search course registrations: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }
}