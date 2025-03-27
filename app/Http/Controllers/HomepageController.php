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

    public function index()
    {

        $product = ProductRepos::getAllProductWithCategory();

        return view('ui.index',
            [
                'product' => $product,

            ]);
    }

    public function show($id_p)
    {

        $product = ProductRepos::getProductById($id_p);

        $category = CategoryRepos::getCategoryByProductId($id_p);

        return view('ui.show',
            [
                'product' => $product[0],//get the first element

                'category' => $category[0],

            ]
        );
    }

//create customer
    public function create()
    {

        return view(
            'ui.new',
            ["customer" => (object)[
                'id_c' => '',
                'fullname_c' => '',
                'dob' => '',
                'gender'=>'',
                'phone_c' => '',
                'email_c' => '',
                'address_c' => ''
            ]]);

    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $product_search = FunctionRepos::searchForProducts($query);

        return view('ui.search',
            [
                'product' => $product_search,

            ]);
    }

    public function listcate()
    {
        $category = CategoryRepos::getAllCategory();

        return view('ui.category',
            [
                'category' => $category,

            ]);
    }

    public function storecustomer(Request $request)
    {
//        dd($request->all());
        $this->formValidate($request)->validate(); //shortcut

        $customer = (object)[
            'fullname_c' => $request->input('fullname_c'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'phone_c' => $request->input('phone_c'),
            'email_c' => $request->input('email_c'),
            'address_c' => $request->input('address_c'),
        ];

        CustomerRepos::insert($customer);

        return view('ui.success');
    }

    public function getproductsfromcate($id)
    {
        $products = FunctionRepos::getProductsByCateId($id);
        $cat = CategoryRepos::getCategoryById($id);
        return view('ui.productsfromcategory',
            [
                'product' => $products,
                'category' => $cat[0],

            ]);
    }

    public function showdetails($id_p)
    {
        $product = ProductRepos::getProductById($id_p);
        return view('ui.details',
            [
                'product' => $product[0],

            ]);
    }

    private function formValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'fullname_c' => ['required','min:5'],
                'dob' => ['required','date_format:"Y-m-d"'],
                'phone_c' => ['required','starts_with:0','digits:10'],
                'email_c' => ['required','email'],

            ],
            [
                'fullname_c.required'=>'Please enter Full name',
                'fullname_c.min'=>'Enter Full Name up to 5 characters',
                'phone_c.required'=>'Please enter Phone',
                'phone_c.starts_with'=>'Enter a phone number starting with 0',
                'phone_c.digits'=>'Please enter exactly 10 numbers',
                'email_c.required'=>'Please enter Email',
                'email_c.email'=>'Please enter email form',
            ]

        );
    }

}
