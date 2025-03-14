<?php
namespace App\Http\Controllers;

use App\Repository\AdminRepos;
use App\Repository\CustomerRepos;
use App\Repository\StaffRepos;
use App\Repository\TeacherRepos;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ManualAuthController extends Controller
{
    public function ask()
    {
        return view('product.manualAuth.login');
    }

    public function signin(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');

        // Lấy dữ liệu từ cả admin và customer
        $adminUsers = AdminRepos::getAllAdmin();
        $customerUsers = CustomerRepos::getAllCustomer();
        $teacherUsers = TeacherRepos::getAllTeacher();
        $staffUsers = StaffRepos::getAllStaff();

     //   $allUsers = array_merge($adminUsers, $customerUsers, $teacherUsers, $staffUsers); // add them tập khách hàng là stu, staff

        $user = null;
        $role = '';
        //$bool = true;

        foreach ($adminUsers as $a)
            // Nếu role là admin, so sánh với username, ngược lại so sánh với email
            if ($a->username === $login && $a->password === sha1($password)) {
                $user = $a;
                $role = 'admin';
            //    $bool == false;
                break;
            } else foreach ($staffUsers as $s)
            // Nếu role là admin, so sánh với username, ngược lại so sánh với email
                if ($s->username === $login && $s->password === $password) {
                $user = $s;
                $role = 'staff';
             //   $bool == false;
                break;
            } else foreach ($customerUsers as $c)
            // Nếu role là admin, so sánh với username, ngược lại so sánh với email
            if ($c->email === $login && $c->password === $password) {
                $user = $c;
                $role = 'customer';
            //    $bool == false;
                break;
            } else foreach ($teacherUsers as $t)
            // Nếu role là admin, so sánh với username, ngược lại so sánh với email
            if ($t->email === $login && $t->password === $password) {
                $user = $t;
                $role = 'teacher';
              //  $bool == false;
                break;
            }




        if ($user) {
            $displayName = $role === 'admin' || $role === 'staff' ? $user->username : $user->email;
            Session::put('username', $displayName);
            Session::put('role', $role);

            // Chuyển hướng dựa trên role
            switch ($role) {
                case 'admin':
                    return redirect()->route('admin.index');
                case 'staff':
                    return redirect()->route('staff.index');
                case 'customer':
                case 'teacher':
                    return redirect()->route('ui.index');
                default:
                    return redirect()->route('home');
            }
        } else {
            return redirect()->action([ManualAuthController::class, 'ask'])
                ->withErrors(['msg' => 'Thông tin đăng nhập không đúng!']);
        }
    }


    public function signout()
    {
        Session::forget('username');
        Session::forget('role');
        return redirect()->action([ManualAuthController::class, 'ask']);
    }
}
