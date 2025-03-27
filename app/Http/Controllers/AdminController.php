<?php

namespace App\Http\Controllers;

use App\Repository\AdminRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $admin = AdminRepos::getAllAdmin();
        return view('admin.index',
            [
                'admin' => $admin,
            ]);
    }

    public function show($id_a)
    {

        $admin = AdminRepos::getAdminById($id_a); //this is always an array
        return view('admin.show',
            [
                'admin' => $admin[0]
            ]
        );
    }

    public function edit($id_a)
    {
        $admin = AdminRepos::getAdminById($id_a); //this is always an array
        return view(
            'admin.update',
            ["admin" => $admin[0]]);
    }

    public function update(Request $request, $id_a)
    {
        if ($id_a != $request->input('id_a')) {
            //id in query string must match id in hidden input
            return redirect()->action('AdminController@index');
        }

        $old_password_input = hash('sha1',$request->input('old_password'));
        $sub = '';
        $passwd = AdminRepos::getAdminById($id_a); //this is always an array
        foreach($passwd as $cat)
        {
            $sub.=$cat->password;
        }
        $this->formValidate($request)->validate();
        if ($old_password_input == $sub) //hash check,
        {
            $admin = (object)[
                'id_a' => $request->input('id_a'),
                'username' => $request->input('username'),
                'fullname_a' => $request->input('fullname_a'),
                'phone_a' => $request->input('phone_a'),
                'email_a' => $request->input('email_a'),
                'password' =>  hash('sha1', $request->input('new_password')),


            ];

            AdminRepos::update($admin);

            return redirect()->action('AdminController@index')
                ->with('msg', 'Update Successfully');

        }
        else
        {
            return redirect()
                ->action('AdminController@index')
                ->withErrors(['msg' => 'Cannot update admin with ID: '.$id_a.'!']);

        }




    }

    private function formValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'username' => ['required'],
                'fullname_a' => ['required','min:5'],
                'phone_a' => ['required','starts_with:0','digits:10'],
                'email_a' => ['required','email'],
                'old_password' => ['required'],
                'new_password' => ['required','min:8'],
                'confirm_password' => ['required_with:new_password','same:new_password'],


            ],
            [

                'fullname_a.required' => 'Please enter Full Name',
                'phone_a.required' => 'Please enter Phone',
                'email_a.required' => 'Please enter Email',
                'old_password.required' => 'Please enter Password',
                'fullname_a.min' => 'Enter Full Name up to 5 characters',
                'phone_a.digits' => 'Please enter phone exactly 10 numbers',
                'phone_a.starts_with' => 'Enter a phone number starting with 0',
                'email_a' => 'Please enter email form',
                'new_password.min'=>'Password must be equal or more than 8 letters!',
                'confirm_password.same'=>'Password confirmation mismatch!',
            ]
        );
    }
}
