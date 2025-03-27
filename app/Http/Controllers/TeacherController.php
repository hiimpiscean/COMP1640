<?php

namespace App\Http\Controllers;

use App\Repository\TeacherRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function index() //TODO: sửa lại cấu trúc trang index
    {
        $teacher = TeacherRepos::getAllTeacher();
        return view('teacher.index',
            [
                'teacher' => $teacher,
            ]);
    }

    public function show($id_t)
    {

        $teacher = TeacherRepos::getTeacherById($id_t); //this is always an array
        return view('teacher.show',
            [
                'teacher' => $teacher[0]
            ]
        );
    }

    public function edit($id_t)
    {
        $teacher = TeacherRepos::getTeacherById($id_t); //this is always an array
        return view(
            'teacher.update',
            ["teacher" => $teacher[0]]);
    }

    public function update(Request $request, $id_t)
    {
        if ($id_t != $request->input('id_t')) {
            //id in query string must match id in hidden input
            return redirect()->action('TeacherController@index');
        }

        $old_password_input = hash('sha1',$request->input('old_password'));
        $sub = '';
        $passwd = TeacherRepos::getTeacherById($id_t); //this is always an array
        foreach($passwd as $cat)
        {
            $sub.=$cat->password;
        }
        $this->formValidate($request)->validate();
        if ($old_password_input == $sub) //hash check,
        {
            $teacher = (object)[
                'id_t' => $request->input('id_t'),
                //      'username' => $request->input('username'),
                'fullname_t' => $request->input('fullname_t'),
                'phone_t' => $request->input('phone_t'),
                'email_t' => $request->input('email_t'),
                'password' =>  hash('sha1', $request->input('new_password')),


            ];

            TeacherRepos::update($teacher);

            return redirect()->action('TeacherController@index')
                ->with('msg', 'Update Successfully');

        }
        else
        {
            return redirect()
                ->action('TeacherController@index')
                ->withErrors(['msg' => 'Cannot update teacher with ID: '.$id_t.'!']);

        }




    }

    private function formValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                //   'username' => ['required'],
                'fullname_t' => ['required','min:5'],
                'phone_t' => ['required','starts_with:0','digits:10'],
                'email_t' => ['required','email'],
                'old_password' => ['required'],
                'new_password' => ['required','min:8'],
                'confirm_password' => ['required_with:new_password','same:new_password'],


            ],
            [

                'fullname_t.required' => 'Please enter Full Name',
                'phone_t.required' => 'Please enter Phone',
                'email_t.required' => 'Please enter Email',
                'old_password.required' => 'Please enter Password',
                'fullname_t.min' => 'Enter Full Name up to 5 characters',
                'phone_t.digits' => 'Please enter phone exactly 10 numbers',
                'phone_t.starts_with' => 'Enter a phone number starting with 0',
                'email_t' => 'Please enter email form',
                'new_password.min'=>'Password must be equal or more than 8 letters!',
                'confirm_password.same'=>'Password confirmation mismatch!',
            ]
        );
    }
}
