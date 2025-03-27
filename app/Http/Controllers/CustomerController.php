<?php

namespace App\Http\Controllers;

use App\Repository\CustomerRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = CustomerRepos::getAllCustomer();
        return view('customer.index',
            [
                'customer' => $customer,
            ]);
    }

    public function show($id_c)
    {

        $customer = CustomerRepos::getCustomerById($id_c);
        return view('customer.show',
            [
                'customer' => $customer[0] //get the first element
            ]
        );
    }

    public function edit($id_c)
    {
        $customer = CustomerRepos::getCustomerById($id_c);


        return view(
            'customer.update',
            ["customer" => $customer[0]]);
    }

    public function update(Request $request, $id_c)
    {
        if ($id_c != $request->input('id_c')) {
            //id in query string must match id in hidden input
            return redirect()->action('CustomerController@index');
        }

        $this->formValidate($request)->validate(); //shortcut

        $customer = (object)[
            'id_c' => $request->input('id_c'),
            'fullname_c' => $request->input('fullname_c'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'phone_c' => $request->input('phone_c'),
            'email_c' => $request->input('email_c'),
            'address_c' => $request->input('address_c'),
        ];
        CustomerRepos::update($customer);

        return redirect()->action('CustomerController@index')
            ->with('msg', 'Update Successfully');;
    }

    public function confirm($id_c){
        $customer = CustomerRepos::getCustomerById($id_c); //this is always an array

        return view('customer.confirm',
            [
                'customer' => $customer[0]
            ]
        );
    }

    public function destroy(Request $request, $id_c)
    {
        if ($request->input('id_c') != $id_c) {
            //id in query string must match id in hidden input
            return redirect()->action('CustomerController@index');
        }

        CustomerRepos::delete($id_c);


        return redirect()->action('CustomerController@index')
            ->with('msg', 'Delete Successfully');
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
