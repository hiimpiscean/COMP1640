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
                    ->with('error', 'Vui lòng đăng nhập để đăng ký khóa học.');
            }
            
            // Kiểm tra role
            if (Session::get('role') !== 'student') {
                return redirect()->back()
                    ->with('error', 'Chỉ học viên mới có thể đăng ký khóa học.');
            }
            
            // Lấy thông tin khóa học
            $course = ProductRepos::getProductById($courseId);
            
            if (!$course) {
                return redirect()->route('learning_materials.curriculum')
                    ->with('error', 'Không tìm thấy khóa học này.');
            }
            
            return view('course_registration.register', compact('course', 'studentName', 'studentEmail'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi hiển thị form đăng ký: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
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
                    'message' => 'Bạn chưa đăng nhập. Vui lòng đăng nhập để đăng ký khóa học.'
                ], 401);
            }
            
            // Kiểm tra role - customer chính là student
            if ($role !== 'customer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Chỉ học viên mới có thể đăng ký khóa học.'
                ], 403);
            }
            
            // Tìm ID học viên dựa trên username/email
            $studentId = $this->findStudentIdByUsername($username);
            
            if (!$studentId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông tin học viên trong hệ thống.'
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
                        'message' => 'Không tìm thấy lịch học cho khóa học này. Vui lòng liên hệ quản trị viên.'
                    ], 404);
                }
            }
            
            // Tạo đăng ký và gửi mail thông báo - sử dụng timetableId thay vì id
            try {
                $this->courseRegistrationService->createRegistration($studentId, $timetableId);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Đăng ký khóa học thành công! Vui lòng chờ xác nhận từ nhân viên.'
                ]);
            } catch (\Exception $e) {
                // Xử lý các exception cụ thể từ service
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Lỗi khi đăng ký khóa học: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi đăng ký khóa học: ' . $e->getMessage()
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
                    ->with('error', 'Bạn không có quyền truy cập trang này.');
            }
            
            // Lấy danh sách đăng ký
            $registrations = $this->courseRegistrationService->getAllPendingRegistrations();
            
            return view('course_registration.staff.index', compact('registrations'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi hiển thị danh sách đăng ký: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
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
                    'message' => 'Bạn không có quyền thực hiện thao tác này.'
                ], 403);
            }
            
            // Phê duyệt đăng ký và gửi mail thông báo
            $this->courseRegistrationService->approveRegistration($registrationId);
            
            return response()->json([
                'success' => true,
                'message' => 'Đã phê duyệt đăng ký khóa học thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi phê duyệt đăng ký: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi phê duyệt đăng ký: ' . $e->getMessage()
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
                    'message' => 'Bạn không có quyền thực hiện thao tác này.'
                ], 403);
            }
            
            // Từ chối đăng ký và gửi mail thông báo
            $this->courseRegistrationService->rejectRegistration($registrationId);
            
            return response()->json([
                'success' => true,
                'message' => 'Đã từ chối đăng ký khóa học!'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi từ chối đăng ký: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi từ chối đăng ký: ' . $e->getMessage()
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
            Log::error('Lỗi khi tìm ID học viên: ' . $e->getMessage());
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
            Log::error('Lỗi khi tìm timetable_id: ' . $e->getMessage());
            return null;
        }
    }
} 