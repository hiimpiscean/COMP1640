<?php

namespace App\Http\Controllers;

use App\Repository\CustomerRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ClassAssignment;
use App\Models\RegistrationRequest;
use App\Models\User;
use App\Notifications\ClassAssigned;
use App\Notifications\TeacherAssignment;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function viewRegistrations()
    {
        $registrations = RegistrationRequest::where('status', 'pending')
            ->with(['student', 'requestedClass'])
            ->latest()
            ->paginate(20);

        return view('staff.registrations', compact('registrations'));
    }

    public function assignClass(Request $request, $registrationId)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'notes' => 'nullable|string'
        ]);

        $registration = RegistrationRequest::findOrFail($registrationId);

        // Cập nhật registration request
        $registration->update([
            'status' => 'assigned',
            'processed_by' => Auth::id(),
            'notes' => $request->notes
        ]);
    }
    public function index()
    {
        $customer = CustomerRepos::getAllCustomer();
        return view('customer.index', compact('customer'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateCustomer($request);

        CustomerRepos::insert((object)$validated);

        return redirect()->route('customer.index')->with('msg', 'Tạo khách hàng thành công!');
    }

    public function show($id_c)
    {
        $customer = CustomerRepos::getCustomerById($id_c);
        return $customer ? view('customer.show', compact('customer'))
            : redirect()->route('customer.index')->with('error', 'Không tìm thấy khách hàng');
    }

    public function edit($id_c)
    {
        $customer = CustomerRepos::getCustomerById($id_c);
        return $customer ? view('customer.edit', compact('customer'))
            : redirect()->route('customer.index')->with('error', 'Không tìm thấy khách hàng');
    }

    public function update(Request $request, $id_c)
    {
        $customer = CustomerRepos::getCustomerById($id_c);
        if (!$customer) {
            return redirect()->route('customer.index')->with('error', 'Không tìm thấy khách hàng');
        }

        if ($request->filled('password')) {
            if ($request->input('old_password') !== $customer->password) {
                return redirect()->back()->with('error', 'Mật khẩu cũ không đúng!');
            }
        }

        $validated = $this->validateCustomer($request, $id_c);
        if (!$request->filled('password')) {
            $validated['password'] = $customer->password; // Giữ nguyên mật khẩu cũ
        }

        CustomerRepos::update((object) array_merge(['id_c' => $id_c], $validated));

        return redirect()->route('customer.index')->with('msg', 'Cập nhật thành công');
    }

    public function confirm($id_c)
    {
        $customer = CustomerRepos::getCustomerById($id_c);
        return $customer ? view('customer.confirm', compact('customer'))
            : redirect()->route('customer.index')->with('error', 'Không tìm thấy khách hàng');
    }

    public function destroy(Request $request, $id_c)
    {
        if ($request->input('id_c') != $id_c) {
            return redirect()->route('customer.index');
        }

        if (!CustomerRepos::getCustomerById($id_c)) {
            return redirect()->route('customer.index')->with('error', 'Không tìm thấy khách hàng');
        }

        CustomerRepos::delete($id_c);
        return redirect()->route('customer.index')->with('msg', 'Xóa thành công');
    }

    private function validateCustomer($request, $id_c = null)
    {
        $rules = [
            'fullname_c'  => 'required|min:5',
            'dob'         => 'required|date_format:Y-m-d',
            'gender'      => 'required|in:Male,Female',
            'phone_c'     => 'required|digits:10|starts_with:0',
            'email' => "required|email|unique:customer,email" . ($id_c ? ",$id_c,id_c" : ''),
            'address_c'   => 'required',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|min:6|confirmed';

            // Chỉ yêu cầu old_password nếu đang cập nhật khách hàng (có $id_c)
            if ($id_c) {
                $rules['old_password'] = 'required';
            }
        }

        return Validator::make($request->all(), $rules, [
            'fullname_c.required'  => 'Vui lòng nhập Họ và Tên',
            'fullname_c.min'       => 'Họ và tên phải có ít nhất 5 ký tự',
            'dob.required'         => 'Vui lòng nhập ngày sinh',
            'dob.date_format'      => 'Ngày sinh không hợp lệ',
            'phone_c.required'     => 'Vui lòng nhập số điện thoại',
            'phone_c.starts_with'  => 'Số điện thoại phải bắt đầu bằng 0',
            'phone_c.digits'       => 'Số điện thoại phải có đúng 10 số',
            'email.required'       => 'Vui lòng nhập Email',
            'email.email'          => 'Email không hợp lệ',
            'email.unique'         => 'Email đã tồn tại',
            'address_c.required'   => 'Vui lòng nhập địa chỉ',
            'password.min'         => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed'   => 'Mật khẩu xác nhận không khớp',
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ để đổi mật khẩu',
        ])->validate();
    }
}
