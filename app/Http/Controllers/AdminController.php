<?php

namespace App\Http\Controllers;

use App\Repository\AdminRepos;
use App\Repository\CustomerRepos;
use App\Repository\StaffRepos;
use App\Repository\TeacherRepos;
use App\Repository\ProductRepos;
use App\Repository\BlogRepos;  // Thêm BlogRepos
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        // Kiểm tra quyền truy cập cho admin và staff
        if (!Session::has('username') || (Session::get('role') !== 'admin' && Session::get('role') !== 'staff')) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập!');
        }

        // Lấy danh sách admin
        $admin = AdminRepos::getAllAdmin();

        // Thống kê số lượng tài khoản
        $totalAdmins = count(AdminRepos::getAllAdmin());
        $totalCustomers = count(CustomerRepos::getAllCustomer());
        $totalStaff = count(StaffRepos::getAllStaff());
        $totalTeachers = count(TeacherRepos::getAllTeacher());
        $totalBlogs = count(BlogRepos::getAllBlog());  // Thêm Blog
        $totalUsers = $totalAdmins + $totalCustomers + $totalStaff + $totalTeachers;

        // Kiểm tra số tài khoản đang đăng nhập
        $loggedInUsers = Session::has('username') ? 1 : 0;

        // Lấy tổng số sản phẩm
        $totalProducts = count(ProductRepos::getAllProduct());

        return view('admin.index', compact('admin', 'totalUsers', 'loggedInUsers', 'totalProducts', 'totalBlogs', 'totalTeachers', 'totalCustomers', 'totalStaff'));
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
