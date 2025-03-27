<?php
namespace App\Http\Controllers;

use App\Repository\TeacherRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TeacherAuthController extends Controller
{
    public function ask()
    {
        return view('product.manualAuth.teacherlogin');
    }

    public function signin(Request $request)
    {
        $information = TeacherRepos::getAllTeacher();
        $username = $request->input('username');
        $password = $request->input('password');
        foreach ($information as $i) {
            if (($i->username) == $username && ($i->password) == sha1($password)) {
                Session::put('username', $request->input('username'));
                return redirect()->route('teacher.index');
            }
        }
        return redirect()->action('TeacherAuthController@ask')
            ->withErrors(['msg' => 'Username or password is incorrect!']);
    }


    public function signout()
    {
        if (Session::has('username')) {
            Session::forget('username');
        }
        return redirect()->action('TeacherAuthController@ask');
    }


}
