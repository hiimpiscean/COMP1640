<?php

namespace App\Http\Controllers;

use App\Repository\TeacherRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash; // Thêm thư viện Hash

class TeacherController extends Controller
{
    public function index()
    {
        $teacher = TeacherRepos::getAllTeacher();
        return view('teacher.index', compact('teacher'));
    }

    public function show($id)
    {
        $teacher = TeacherRepos::getTeacherById($id)[0] ?? null;
        return $teacher ? view('teacher.show', compact('teacher')) : redirect()->route('teacher.index')->with('error', 'Giáo viên không tồn tại');
    }

    public function create()
    {
        return view('teacher.create');
    }

    public function store(Request $request)
    {
        $validated = $this->formValidate($request)->validate();

        // Mã hóa mật khẩu trước khi lưu
        $validated['password'] = Hash::make($request->password);

        TeacherRepos::insert((object) $validated);
        return redirect()->route('teacher.index')->with('msg', 'Thêm giáo viên thành công!');
    }

    public function edit($id)
    {
        $teacher = TeacherRepos::getTeacherById($id)[0] ?? null;
        return $teacher ? view('teacher.edit', compact('teacher')) : redirect()->route('teacher.index')->with('error', 'Giáo viên không tồn tại');
    }

    public function update(Request $request, $id)
    {
        if ($id != $request->id_t) {
            return redirect()->route('teacher.index')->with('error', 'Dữ liệu không hợp lệ!');
        }

        $teacher = TeacherRepos::getTeacherById($id)[0] ?? null;
        if (!$teacher) {
            return redirect()->route('teacher.index')->with('error', 'Giáo viên không tồn tại!');
        }

        // Nếu nhập mật khẩu mới, kiểm tra mật khẩu cũ
        if ($request->filled('password')) {
            if (!Hash::check($request->old_password, $teacher->password)) {
                return redirect()->back()->with('error', 'Mật khẩu cũ không đúng!');
            }


            if ($request->password !== $request->password_confirmation) {
                return redirect()->back()->with('error', 'Mật khẩu xác nhận không khớp!');
            }

            // Mã hóa mật khẩu mới
            $validated['password'] = Hash::make($request->password);
        } else {
            // Giữ mật khẩu cũ nếu không thay đổi
            $validated['password'] = $teacher->password;
        }

        // Validate dữ liệu nhập vào
        $validated = $this->formValidate($request)->validate();
        $validated['id_t'] = $id;

        // Cập nhật thông tin giáo viên
        TeacherRepos::update((object) $validated);

        return redirect()->route('teacher.index')->with('msg', 'Cập nhật thành công!');
    }

    public function confirm($id)
    {
        $teacher = TeacherRepos::getTeacherById($id)[0] ?? null;
        return $teacher ? view('teacher.confirm', compact('teacher')) : redirect()->route('teacher.index')->with('error', 'Giáo viên không tồn tại');
    }

    public function destroy(Request $request, $id_t)
    {
        if ($id_t != $request->route('id_t')) {
            return redirect()->route('teacher.index');
        }

        if (!TeacherRepos::getTeacherById($id_t)[0] ?? null) {
            return redirect()->route('teacher.index')->with('error', 'Không tìm thấy giáo viên');
        }

        TeacherRepos::delete($id_t);
        return redirect()->route('teacher.index')->with('msg', 'Xóa thành công');
    }

    private function formValidate($request, $id_t = null)
    {
        $rules = [
            'fullname_t' => 'required|min:5',
            'phone_t' => 'required|digits:10|starts_with:0',
            'email' => 'required|email',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|min:6|confirmed';
            if ($id_t) {
                $rules['old_password'] = 'required';
            }
        }

        $messages = [
            'fullname_t.required' => 'Vui lòng nhập Họ và Tên',
            'fullname_t.min' => 'Họ và tên phải có ít nhất 5 ký tự',
            'phone_t.required' => 'Vui lòng nhập số điện thoại',
            'phone_t.digits' => 'Số điện thoại phải có đúng 10 số',
            'phone_t.starts_with' => 'Số điện thoại phải bắt đầu bằng 0',
            'email.required' => 'Vui lòng nhập Email',
            'email.email' => 'Email không hợp lệ',
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ để đổi mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }
}
