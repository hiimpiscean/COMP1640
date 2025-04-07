<?php

namespace App\Http\Controllers;

use App\Repository\CategoryRepos;
use App\Repository\CustomerRepos;
use App\Repository\FunctionRepos;
use App\Repository\ProductRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomepageController extends Controller
{
    // Hiển thị trang chủ với sản phẩm và danh mục
    public function index()
    {
        $product = ProductRepos::getAllProductWithCategory();
        $category = CategoryRepos::getAllCategory();

        return view('ui.index', [
            'product' => $product,
            'category' => $category,
        ]);
    }

    // Hiển thị trang chính với danh mục
    public function home()
    {
        $category = CategoryRepos::getAllCategory();
        $product = ProductRepos::getAllProductWithCategory();

        return view('ui.home', ['category' => $category, 'product' => $product,]);
    }

    // Hiển thị một sản phẩm cụ thể và danh mục của nó
    public function show($id_p)
    {
        $product = ProductRepos::getProductById($id_p);
        $category = CategoryRepos::getCategoryByProductId($id_p);

        return view('ui.show', [
            'product' => $product[0],
            'category' => $category[0],
        ]);
    }

    // Hiển thị form tạo khách hàng mới
    public function create()
    {
        return view('ui.new', [
            'customer' => (object)[
                'id_c' => '',
                'fullname_c' => '',
                'dob' => '',
                'gender' => '',
                'phone_c' => '',
                'email' => '',
                'address_c' => '',
            ],
        ]);
    }

    // Tìm kiếm sản phẩm dựa trên từ khóa
    public function search(Request $request)
    {
        $query = $request->input('query');
        $product_search = FunctionRepos::searchForProducts($query);

        return view('ui.search', [
            'product' => $product_search,
            'query' => $query
        ]);
    }

    // Lưu khách hàng mới vào cơ sở dữ liệu
    public function storecustomer(Request $request)
    {
        $this->formValidate($request)->validate();

        $customer = (object)[
            'fullname_c' => $request->input('fullname_c'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'phone_c' => $request->input('phone_c'),
            'email' => $request->input('email'),
            'address_c' => $request->input('address_c'),
        ];

        CustomerRepos::insert($customer);

        return view('customer.index');
    }

    // Lấy sản phẩm theo danh mục ID
    public function getproductsfromcate($id)
    {
        $products = FunctionRepos::getProductsByCateId($id);
        $cat = CategoryRepos::getCategoryById($id);

        return view('ui.productsfromcategory', [
            'product' => $products,
            'category' => $cat[0],
        ]);
    }

    // Hiển thị chi tiết của một sản phẩm cụ thể
    public function showdetails($id_p)
    {
        $product = ProductRepos::getProductById($id_p);

        return view('ui.details', [
            'product' => $product[0],
        ]);
    }

    // Xác thực dữ liệu của form tạo khách hàng
    private function formValidate($request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'fullname_c' => ['required', 'min:5'],
            'dob' => ['required', 'date_format:"Y-m-d"'],
            'phone_c' => ['required', 'starts_with:0', 'digits:10'],
            'email' => ['required', 'email'],
        ], [
            'fullname_c.required' => 'Vui lòng nhập tên đầy đủ',
            'fullname_c.min' => 'Vui lòng nhập tên đầy đủ ít nhất 5 ký tự',
            'phone_c.required' => 'Vui lòng nhập số điện thoại',
            'phone_c.starts_with' => 'Vui lòng nhập số điện thoại bắt đầu bằng số 0',
            'phone_c.digits' => 'Vui lòng nhập đúng 10 chữ số',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Vui lòng nhập đúng định dạng email',
        ]);
    }
}
