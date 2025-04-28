<?php

namespace App\Http\Controllers;

use App\Repository\AdminRepos;
use App\Repository\CustomerRepos;
use App\Repository\StaffRepos;
use App\Repository\TeacherRepos;
use App\Repository\ProductRepos;
use App\Repository\BlogRepos;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // Kiểm tra quyền truy cập cho admin và staff
        if (!Session::has('username') || (Session::get('role') !== 'admin' && Session::get('role') !== 'staff')) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập!');
        }

        // Lấy tổng số sản phẩm
        $totalProducts = count(ProductRepos::getAllProduct());

        // Lấy tổng số đăng ký
        $totalRegistrations = DB::table('course_registrations')->count();

        // Lấy tổng số blog
        $totalBlogs = count(BlogRepos::getAllBlog());

        // Lấy tổng số giáo viên
        $totalTeachers = count(TeacherRepos::getAllTeacher());

        // Lấy tổng số học viên
        $totalCustomers = count(CustomerRepos::getAllCustomer());

        // Lấy thống kê đăng ký theo tháng
        $registrationStats = DB::table('course_registrations')
            ->select(DB::raw('EXTRACT(MONTH FROM created_at) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Lấy thống kê khóa học theo danh mục
        $coursesByCategory = DB::table('product')
            ->join('category', 'product.categoryid', '=', 'category.id_cate')
            ->select('category.name_cate', DB::raw('COUNT(*) as total'))
            ->groupBy('category.name_cate')
            ->get();

        // Lấy top 5 khóa học có nhiều đăng ký nhất
        $topCourses = DB::table('course_registrations')
            ->join('product', 'course_registrations.course_id', '=', 'product.id_p')
            ->select('product.name_p', DB::raw('COUNT(*) as registrations'))
            ->groupBy('product.name_p')
            ->orderByDesc('registrations')
            ->limit(5)
            ->get();

        // Lấy thống kê đăng ký trong tháng này
        $monthlyRegistrations = DB::table('course_registrations')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->whereRaw('EXTRACT(MONTH FROM created_at) = ?', [date('m')])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Lấy số đăng ký mới trong tháng hiện tại
        $currentMonthRegistrations = DB::table('course_registrations')
            ->whereRaw('EXTRACT(MONTH FROM created_at) = ?', [date('m')])
            ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [date('Y')])
            ->count();

        // Lấy số khóa học mới trong tháng hiện tại
        $currentMonthProducts = 0; // Default to 0 since we can't track creation date

        // Lấy số blog mới trong tháng hiện tại
        $currentMonthBlogs = 0; // Default to 0 since we can't track creation date

        // Lấy số giáo viên mới trong tháng hiện tại
        $currentMonthTeachers = 0; // Default to 0 since we can't track creation date

        // Lấy số học viên mới trong tháng hiện tại
        $currentMonthStudents = 0; // Default to 0 since we can't track creation date

        // Lấy danh sách admin
        $admin = AdminRepos::getAllAdmin();

        return view('admin.index', [
            'totalProducts' => $totalProducts,
            'totalRegistrations' => $totalRegistrations,
            'totalBlogs' => $totalBlogs,
            'totalTeachers' => $totalTeachers,
            'totalCustomers' => $totalCustomers,
            'registrationStats' => $registrationStats,
            'coursesByCategory' => $coursesByCategory,
            'topCourses' => $topCourses,
            'monthlyRegistrations' => $monthlyRegistrations,
            'currentMonthRegistrations' => $currentMonthRegistrations,
            'currentMonthProducts' => $currentMonthProducts,
            'currentMonthBlogs' => $currentMonthBlogs,
            'currentMonthTeachers' => $currentMonthTeachers,
            'currentMonthStudents' => $currentMonthStudents,
            'admin' => $admin
        ]);
    }

    public function show($id_a)
    {
        $admin = AdminRepos::getAdminById($id_a);
        return view('admin.show', ['admin' => $admin[0]]);
    }

    public function edit($id_a)
    {
        $admin = AdminRepos::getAdminById($id_a);
        return view('admin.update', ['admin' => $admin[0]]);
    }

    public function update(Request $request, $id_a)
    {
        if ($id_a != $request->input('id_a')) {
            return redirect()->route('admin.index');
        }

        $old_password_input = hash('sha1', $request->input('old_password'));
        $adminData = AdminRepos::getAdminById($id_a);
        $storedPassword = $adminData[0]->password;

        $this->formValidate($request)->validate();

        if ($old_password_input === $storedPassword) {
            $admin = (object) [
                'id_a' => $request->input('id_a'),
                'username' => $request->input('username'),
                'fullname_a' => $request->input('fullname_a'),
                'phone_a' => $request->input('phone_a'),
                'email_a' => $request->input('email_a'),
                'password' => hash('sha1', $request->input('new_password')),
            ];

            AdminRepos::update($admin);

            return redirect()->route('admin.index')->with('msg', 'Cập nhật thành công!');
        } else {
            return redirect()->route('admin.index')->withErrors(['msg' => 'Mật khẩu cũ không chính xác!']);
        }
    }

    private function formValidate($request)
    {
        return Validator::make($request->all(), [
            'username' => ['required'],
            'fullname_a' => ['required', 'min:5'],
            'phone_a' => ['required', 'starts_with:0', 'digits:10'],
            'email_a' => ['required', 'email'],
            'old_password' => ['required'],
            'new_password' => ['required', 'min:8'],
            'confirm_password' => ['required_with:new_password', 'same:new_password'],
        ], [
            'fullname_a.required' => 'Vui lòng nhập Họ và Tên',
            'phone_a.required' => 'Vui lòng nhập Số điện thoại',
            'email_a.required' => 'Vui lòng nhập Email',
            'old_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'fullname_a.min' => 'Tên phải có ít nhất 5 ký tự',
            'phone_a.digits' => 'Số điện thoại phải có 10 số',
            'phone_a.starts_with' => 'Số điện thoại phải bắt đầu bằng số 0',
            'email_a.email' => 'Định dạng email không hợp lệ',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự',
            'confirm_password.same' => 'Xác nhận mật khẩu không khớp!',
        ]);
    }
}
