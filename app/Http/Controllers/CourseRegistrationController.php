<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseRegistrationService;
use App\Repository\ProductRepos;
use App\Repository\TeacherRepos;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\CourseRegistrationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Repository\CourseRegistrationRepos;

class CourseRegistrationController extends Controller
{
    protected $courseRegistrationService;

    public function __construct(CourseRegistrationService $courseRegistrationService)
    {
        $this->courseRegistrationService = $courseRegistrationService;
        
        // Middleware nên được thêm vào sau
        $this->middleware('manual.auth');
    }

    /**
     * Hiển thị form đăng ký khóa học
     *
     * @param int $courseId
     * @return \Illuminate\View\View
     */
    public function showRegisterForm($courseId)
    {
        try {
            // Lấy thông tin người dùng từ session
            $studentId = Session::get('id');
            $studentName = Session::get('name');
            $studentEmail = Session::get('email');
            
            if (!$studentId) {
                return redirect()->route('auth.ask')
                    ->with('error', 'Please login to register for a course.');
            }
            
            // Kiểm tra role
            if (Session::get('role') !== 'student') {
                return redirect()->back()
                    ->with('error', 'Only students can register for courses.');
            }
            
            // Lấy thông tin khóa học
            $course = ProductRepos::getProductById($courseId);
            
            if (!$course) {
                return redirect()->route('learning_materials.curriculum')
                    ->with('error', 'Cannot find this course.');
            }
            
            return view('course_registration.register', compact('course', 'studentName', 'studentEmail'));
        } catch (\Exception $e) {
            Log::error('Error when displaying the registration form: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred. Please try again later.');
        }
    }

    /**
     * Xử lý đăng ký khóa học
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request, $id)
    {
        try {
            // Lấy thông tin người dùng từ session
            $username = Session::get('username');
            $role = Session::get('role');
            
            if (!$username) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not logged in. Please login to register for a course.'
                ], 401);
            }
            
            // Kiểm tra role - customer chính là student
            if ($role !== 'customer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only students can register for courses.'
                ], 403);
            }
            
            // Tìm ID học viên dựa trên username/email
            $studentId = $this->findStudentIdByUsername($username);
            
            if (!$studentId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot find student information in the system.'
                ], 404);
            }
            
            // Lấy timetable_id từ request hoặc sử dụng một truy vấn để tìm
            $timetableId = $request->input('timetable_id');
            
            // Nếu không có timetable_id, thử tìm trong database
            if (!$timetableId) {
                // Tìm timetable_id từ course_id
                $timetableId = $this->findTimetableIdByCourseId($id);
                
                if (!$timetableId) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot find the course schedule. Please contact the administrator.'
                    ], 404);
                }
            }
            
            // Tạo đăng ký và gửi mail thông báo - sử dụng timetableId thay vì id
            try {
                $this->courseRegistrationService->createRegistration($studentId, $timetableId);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Course registration successful! Please wait for confirmation from the staff.'
                ]);
            } catch (\Exception $e) {
                // Xử lý các exception cụ thể từ service
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error when registering for a course: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred when registering for a course: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hiển thị danh sách đăng ký (dành cho nhân viên)
     *
     * @return \Illuminate\View\View
     */
    public function staffIndex()
    {
        try {
            // Kiểm tra quyền nhân viên
            if (Session::get('role') !== 'staff' && Session::get('role') !== 'admin') {
                return redirect()->back()
                    ->with('error', 'You do not have permission to access this page.');
            }
            
            // Lấy danh sách đăng ký
            $registrations = $this->courseRegistrationService->getAllPendingRegistrations();
            
            return view('course_registration.staff.index', compact('registrations'));
        } catch (\Exception $e) {
            Log::error('Error when displaying the registration list: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred. Please try again later.');
        }
    }

    /**
     * Phê duyệt đăng ký khóa học
     *
     * @param int $registrationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve($registrationId)
    {
        try {
            // Kiểm tra quyền nhân viên
            if (Session::get('role') !== 'staff' && Session::get('role') !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to perform this action.'
                ], 403);
            }
            
            // Phê duyệt đăng ký và gửi mail thông báo
            $this->courseRegistrationService->approveRegistration($registrationId);
            
            return response()->json([
                'success' => true,
                'message' => 'Course registration approved successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error when approving the registration: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred when approving the registration: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Từ chối đăng ký khóa học
     *
     * @param int $registrationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function reject($registrationId)
    {
        try {
            // Kiểm tra quyền nhân viên
            if (Session::get('role') !== 'staff' && Session::get('role') !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to perform this action.'
                ], 403);
            }
            
            // Từ chối đăng ký và gửi mail thông báo
            $this->courseRegistrationService->rejectRegistration($registrationId);
            
            return response()->json([
                'success' => true,
                'message' => 'Course registration rejected successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error when rejecting the registration: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred when rejecting the registration: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tìm ID học viên dựa trên username hoặc email
     * 
     * @param string $username
     * @return int|null
     */
    private function findStudentIdByUsername($username)
    {
        // Trong database customer, tìm theo email vì không có username
        try {
            // Đầu tiên tìm theo email chính xác
            $student = \App\Repository\CustomerRepos::getCustomerByEmail($username);
            if ($student) {
                return $student->id_c;
            }
            
            // Nếu không tìm thấy, thử truy vấn tất cả customer và lọc thủ công
            $allCustomers = \App\Repository\CustomerRepos::getAllCustomer();
            foreach ($allCustomers as $customer) {
                // So sánh với email hoặc fullname
                if ($customer->email === $username || $customer->fullname_c === $username) {
                    return $customer->id_c;
                }
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Error when finding student ID: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Tìm timetable_id dựa trên course_id
     * 
     * @param int $courseId
     * @return int|null
     */
    private function findTimetableIdByCourseId($courseId)
    {
        try {
            $sql = "SELECT id FROM timetable WHERE course_id = ? LIMIT 1";
            $result = DB::select($sql, [$courseId]);
            return $result ? $result[0]->id : null;
        } catch (\Exception $e) {
            Log::error('Error when finding timetable_id: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Hiển thị danh sách quản lý khóa học và trạng thái đăng ký
     *
     * @return \Illuminate\View\View
     */
    public function courseManagement()
    {
        try {
            // Kiểm tra quyền nhân viên
            if (Session::get('role') !== 'staff' && Session::get('role') !== 'admin') {
                return redirect()->back()
                    ->with('error', 'You do not have permission to access this page.');
            }
            
            // Lấy danh sách tất cả khóa học
            $courses = \App\Repository\ProductRepos::getAllProduct();
            
            // Lấy số lượng đăng ký cho mỗi khóa học
            $coursesWithRegistrationData = [];
            
            foreach ($courses as $course) {
                // Kiểm tra trong bảng timetable
                $timetableId = $this->findTimetableIdByCourseId($course->id_p);
                $courseId = $timetableId ?? $course->id_p;
                
                // Đếm số đăng ký cho khóa học này
                $pendingCount = 0;
                $approvedCount = 0;
                $rejectedCount = 0;
                
                try {
                    $registrations = CourseRegistrationRepos::getByCourseId($courseId);
                    
                    foreach ($registrations as $reg) {
                        if ($reg->status === 'pending') {
                            $pendingCount++;
                        } elseif ($reg->status === 'approved') {
                            $approvedCount++;
                        } elseif ($reg->status === 'rejected') {
                            $rejectedCount++;
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Error when counting registrations for course ' . $course->id_p . ': ' . $e->getMessage());
                }
                
                $course->pending_count = $pendingCount;
                $course->approved_count = $approvedCount;
                $course->rejected_count = $rejectedCount;
                $course->timetable_id = $timetableId;
                
                $coursesWithRegistrationData[] = $course;
            }
            
            return view('course_registration.staff.course_management', [
                'courses' => $coursesWithRegistrationData
            ]);
        } catch (\Exception $e) {
            Log::error('Error when displaying the course management page: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred when loading the course management page: ' . $e->getMessage());
        }
    }
    
    /**
     * Từ chối tất cả đăng ký đang chờ xử lý cho một khóa học
     *
     * @param int $courseId
     * @return \Illuminate\Http\JsonResponse
     */
    public function rejectAllPendingRegistrations($courseId)
    {
        try {
            // Kiểm tra quyền nhân viên
            if (Session::get('role') !== 'staff' && Session::get('role') !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to perform this action.'
                ], 403);
            }
            
            // Lấy danh sách đăng ký đang chờ xử lý
            $registrations = CourseRegistrationRepos::getByCourseId($courseId);
            $pendingRegistrations = array_filter($registrations, function($reg) {
                return $reg->status === 'pending';
            });
            
            // Từ chối từng đăng ký một
            $successCount = 0;
            $errorCount = 0;
            
            foreach ($pendingRegistrations as $registration) {
                try {
                    $this->courseRegistrationService->rejectRegistration($registration->id);
                    $successCount++;
                } catch (\Exception $e) {
                    Log::error('Error when rejecting registration ID ' . $registration->id . ': ' . $e->getMessage());
                    $errorCount++;
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Rejected ' . $successCount . ' course registrations. ' . 
                            ($errorCount > 0 ? $errorCount . ' registrations encountered errors.' : '')
            ]);
        } catch (\Exception $e) {
            Log::error('Error when rejecting all registrations for course ' . $courseId . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                 'message' => 'An error occurred when rejecting the registrations: ' . $e->getMessage()
            ], 500);
        }
    }
} 