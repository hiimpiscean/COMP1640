<?php

namespace App\Http\Controllers;

use App\Repository\StaffRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function index()
    {
        $staff = StaffRepos::getAllStaff();
        return view('staff.index', compact('staff'));
    }

    public function show($id_s)
    {
        $staff = StaffRepos::getStaffById($id_s)[0] ?? null;
        return $staff ? view('staff.show', compact('staff')) : redirect()->route('staff.index')->with('error', 'Nhân viên không tồn tại');
    }

    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        $validated = $this->formValidate($request)->validate();
        $validated['password'] = $request->password;

        StaffRepos::insert((object)$validated);
        return redirect()->route('staff.index')->with('msg', 'Thêm nhân viên thành công!');
    }

    public function edit($id_s)
    {
        $staff = StaffRepos::getStaffById($id_s)[0] ?? null;
        return $staff ? view('staff.edit', compact('staff')) : redirect()->route('staff.index')->with('error', 'Nhân viên không tồn tại');
    }

    public function update(Request $request, $id_s)
    {
        if ($id_s != $request->id_s) {
            return redirect()->route('staff.index')->with('error', 'Dữ liệu không hợp lệ!');
        }

        $staff = StaffRepos::getStaffById($id_s)[0] ?? null;
        if (!$staff) {
            return redirect()->route('staff.index')->with('error', 'Nhân viên không tồn tại!');
        }

        if ($request->filled('password')) {
            if ($request->old_password !== $staff->password) {
                return redirect()->back()->with('error', 'Mật khẩu cũ không đúng!');
            }
            if ($request->password !== $request->password_confirmation) {
                return redirect()->back()->with('error', 'Mật khẩu xác nhận không khớp!');
            }
        }

        $validated = $this->formValidate($request)->validate();
        $validated['id_s'] = $id_s;
        $validated['password'] = $request->filled('password') ?  $request->password : $staff->password;

        StaffRepos::update((object)$validated);
        return redirect()->route('staff.index')->with('msg', 'Cập nhật thành công!');
    }

    public function confirm($id_s)
    {
        $staff = StaffRepos::getStaffById($id_s)[0] ?? null;
        return $staff ? view('staff.confirm', compact('staff')) : redirect()->route('staff.index')->with('error', 'Nhân viên không tồn tại');
    }

    public function destroy(Request $request, $id_s)
    {
        if ($id_s != $request->route('id_s')) {
            return redirect()->route('staff.index');
        }

        if (!StaffRepos::getStaffById($id_s)[0] ?? null) {
            return redirect()->route('staff.index')->with('error', 'Không tìm thấy nhân viên');
        }

        StaffRepos::delete($id_s);
        return redirect()->route('staff.index')->with('msg', 'Xóa thành công');
    }

    private function formValidate($request, $id_s = null)
    {
        $rules = [
            'username'   => 'required',
            'fullname_s' => 'required|min:5',
            'phone_s'    => 'required|digits:10|starts_with:0',
            'email'      => 'required|email',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|min:6|confirmed';
            if ($id_s) {
                $rules['old_password'] = 'required';
            }
        }

        $messages = [
            'fullname_s.required' => 'Vui lòng nhập Họ và Tên',
            'fullname_s.min'      => 'Họ và tên phải có ít nhất 5 ký tự',
            'phone_s.required'    => 'Vui lòng nhập số điện thoại',
            'phone_s.digits'      => 'Số điện thoại phải có đúng 10 số',
            'phone_s.starts_with' => 'Số điện thoại phải bắt đầu bằng 0',
            'email.required'      => 'Vui lòng nhập Email',
            'email.email'         => 'Email không hợp lệ',
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ để đổi mật khẩu',
            'password.min'    => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }
}
