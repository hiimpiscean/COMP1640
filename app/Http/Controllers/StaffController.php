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
        return view('staff.index',
            [
                'staff' => $staff,
            ]);
    }

    public function show($id_s)
    {

        $staff = StaffRepos::getStaffById($id_s); //this is always an array
        return view('staff.show',
            [
                'staff' => $staff[0]
            ]
        );
    }

    public function edit($id_s)
    {
        $staff = StaffRepos::getStaffById($id_s); //this is always an array
        return view(
            'staff.update',
            ["staff" => $staff[0]]);
    }

    public function update(Request $request, $id_s)
    {
        if ($id_s != $request->input('id_s')) {
            //id in query string must match id in hidden input
            return redirect()->action('StaffController@index');
        }

        $old_password_input = hash('sha1',$request->input('old_password'));
        $sub = '';
        $passwd = StaffRepos::getStaffById($id_s); //this is always an array
        foreach($passwd as $cat)
        {
            $sub.=$cat->password;
        }
        $this->formValidate($request)->validate();
        if ($old_password_input == $sub) //hash check,
        {
            $staff = (object)[
                'id_s' => $request->input('id_s'),
                'username' => $request->input('username'),
                'fullname_s' => $request->input('fullname_s'),
                'phone_s' => $request->input('phone_s'),
                'email' => $request->input('email'),
                'password' =>  hash('sha1', $request->input('new_password')),


            ];

            StaffRepos::update($staff);

            return redirect()->action('StaffController@index')
                ->with('msg', 'Update Successfully');

        }
        else
        {
            return redirect()
                ->action('StaffController@index')
                ->withErrors(['msg' => 'Cannot update staff with ID: '.$id_s.'!']);

        }




    }

    private function formValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'username' => ['required'],
                'fullname_s' => ['required','min:5'],
                'phone_s' => ['required','starts_with:0','digits:10'],
                'email' => ['required','email'],
                'old_password' => ['required'],
                'new_password' => ['required','min:8'],
                'confirm_password' => ['required_with:new_password','same:new_password'],


            ],
            [

                'fullname_s.required' => 'Please enter Full Name',
                'phone_s.required' => 'Please enter Phone',
                'email.required' => 'Please enter Email',
                'old_password.required' => 'Please enter Password',
                'fullname_s.min' => 'Enter Full Name up to 5 characters',
                'phone_s.digits' => 'Please enter phone exactly 10 numbers',
                'phone_s.starts_with' => 'Enter a phone number starting with 0',
                'email' => 'Please enter email form',
                'new_password.min'=>'Password must be equal or more than 8 letters!',
                'confirm_password.same'=>'Password confirmation mismatch!',
            ]
        );
    }
}
