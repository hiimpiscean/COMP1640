<?php

namespace App\Http\Controllers;

use App\Repository\CustomerRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // Hiển thị danh sách khách hàng
    public function index()
    {
        $customer = CustomerRepos::getAllCustomer();
        return view('customer.index', ['customer' => $customer]);
    }

    // Hiển thị form tạo mới khách hàng
    public function create()
    {
        // Khởi tạo đối tượng rỗng với các thuộc tính mặc định
        $customer = (object)[
            'id_c'        => null,
            'fullname_c'  => '',
            'dob'         => '',
            'gender'      => '',
            'phone_c'     => '',
            'email'     => '',
            'address_c'   => '',
            'password'  => null,
        ];
        return view('customer.create', ['customer' => $customer]);
    }

    // Xử lý lưu khách hàng mới
    public function store(Request $request)
    {
        $this->formValidate($request)->validate();

        $customer = (object)[
            'fullname_c'  => $request->input('fullname_c'),
            'dob'         => $request->input('dob'),
            'gender'      => $request->input('gender'),
            'phone_c'     => $request->input('phone_c'),
            'email'       => $request->input('email'),
            'address_c'   => $request->input('address_c'),
            'password'    => $request->input('password'),
        ];

        CustomerRepos::insert($customer);

        return redirect()->action([CustomerController::class, 'index'])
            ->with('msg', 'Tạo khách hàng thành công!');
    }

    // Hiển thị thông tin chi tiết khách hàng
    public function show($id_c)
    {
        $customer = CustomerRepos::getCustomerById($id_c);
        if (!$customer) {
            return redirect()->action([CustomerController::class, 'index'])
                ->with('error', 'Không tìm thấy khách hàng');
        }
        return view('customer.show', ['customer' => $customer]);
    }

    // Hiển thị form cập nhật khách hàng
    public function edit($id_c)
    {
        $customer = CustomerRepos::getCustomerById($id_c);
        if (!$customer) {
            return redirect()->action([CustomerController::class, 'index'])
                ->with('error', 'Không tìm thấy khách hàng');
        }
        return view('customer.edit', ['customer' => $customer]);
    }

    // Xử lý cập nhật thông tin khách hàng
    public function update(Request $request, $id_c)
    {
        if ($id_c != $request->input('id_c')) {
            return redirect()->action([CustomerController::class, 'index']);
        }

        $this->formValidate($request, true)->validate();

        $customer = (object)[
            'id_c'        => $request->input('id_c'),
            'fullname_c'  => $request->input('fullname_c'),
            'dob'         => $request->input('dob'),
            'gender'      => $request->input('gender'),
            'phone_c'     => $request->input('phone_c'),
            'email'       => $request->input('email'),
            'address_c'   => $request->input('address_c'),
            'password'    => $request->filled('password') ? $request->input('password') : CustomerRepos::getCustomerById($id_c)->password,
        ];

        CustomerRepos::update($customer);

        return redirect()->action([CustomerController::class, 'index'])
            ->with('msg', 'Cập nhật thành công');
    }

    // Xác nhận trước khi xóa khách hàng
    public function confirm($id_c)
    {
        $customer = CustomerRepos::getCustomerById($id_c);
        if (!$customer) {
            return redirect()->action([CustomerController::class, 'index'])
                ->with('error', 'Không tìm thấy khách hàng');
        }
        return view('customer.confirm', ['customer' => $customer]);
    }

    // Xử lý xóa khách hàng
    public function destroy(Request $request, $id_c)
    {
        if ($request->input('id_c') != $id_c) {
            return redirect()->action([CustomerController::class, 'index']);
        }

        $customer = CustomerRepos::getCustomerById($id_c);
        if (!$customer) {
            return redirect()->action([CustomerController::class, 'index'])
                ->with('error', 'Không tìm thấy khách hàng');
        }

        CustomerRepos::delete($id_c);

        return redirect()->action([CustomerController::class, 'index'])
            ->with('msg', 'Xóa thành công');
    }

    // Hàm validate dữ liệu từ form
    private function formValidate($request, $isUpdate = false): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'fullname_c'  => ['required', 'min:5'],
            'dob'         => ['required', 'date_format:Y-m-d'],
            'phone_c'     => ['required', 'starts_with:0', 'digits:10'],
            'email'     => ['required', 'email'],
        ];

        // Chỉ bắt buộc mật khẩu khi tạo mới hoặc khi có nhập mật khẩu mới
        if (!$isUpdate || $request->filled('password')) {
            $rules['password'] = ['required', 'min:6', 'confirmed'];
        }

        return Validator::make(
            $request->all(),
            $rules,
            [
                'fullname_c.required'  => 'Please enter Full name',
                'fullname_c.min'       => 'Enter Full Name up to 5 characters',
                'phone_c.required'     => 'Please enter Phone',
                'phone_c.starts_with'  => 'Enter a phone number starting with 0',
                'phone_c.digits'       => 'Please enter exactly 10 numbers',
                'email.required'     => 'Please enter Email',
                'email.email'        => 'Please enter email form',
                'password.min'       => 'Password must be at least 6 characters',
                'password.confirmed' => 'Password confirmation does not match',
            ]
        );
    }
}
