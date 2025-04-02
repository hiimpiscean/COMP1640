<?php
namespace App\Http\Controllers;

use App\Repository\AdminRepos;
use App\Repository\CustomerRepos;
use App\Repository\StaffRepos;
use App\Repository\TeacherRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash; // Thêm thư viện Hash

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

            if ($a->username === $login && $a->password === sha1($password)) {
                $user = $a;
                $role = 'admin';
                //    $bool == false;
                break;
            } else
                foreach ($staffUsers as $s)

                    if ($s->username === $login && Hash::check($password, $s->password)) {
                        $user = $s;
                        $role = 'staff';
                        break;
                    } else
                        foreach ($customerUsers as $c)

                            if ($c->email === $login && Hash::check($password, $c->password)) {
                                $user = $c;
                                $role = 'customer';
                                break;
                            } else
                                foreach ($teacherUsers as $t)

                                    if ($t->email === $login && Hash::check($password, $t->password)) {
                                        $user = $t;
                                        $role = 'teacher';
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
        return redirect()->route('ui.index');
    }
}
