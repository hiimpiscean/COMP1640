<?php
namespace App\Http\Controllers;

use App\Repository\AdminRepos;
use App\Repository\CustomerRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
       // $teacherUsers = TeacherRepos::getAllTeacher();

        $allUsers = array_merge($adminUsers, $customerUsers); //TODO: add them tập khách hàng là stu

        $user = null;
        foreach ($allUsers as $i) {
            // Nếu role là admin, so sánh với username, ngược lại so sánh với email
            if ($i->role === 'admin') {
                if ($i->username === $login && $i->password === sha1($password)) {
                    $user = $i;
                    break;
                }
            } else {
                if ($i->email === $login && Hash::check($password, $i->password)) {
                    $user = $i;
                    break;
                }
            }
        }

        if ($user) {
            $displayName = $user->role === 'admin' ? $user->username : $user->email;
            Session::put('username', $displayName);
            Session::put('role', $user->role);

            // Chuyển hướng dựa trên role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.index');
                case 'staff':
                    return redirect()->route('staff.index');
                case 'teacher':
                    return redirect()->route('teacher.index');
                case 'customer':
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
