<?php
namespace App\Http\Controllers;

use App\Repository\AdminRepos;
use App\Repository\CustomerRepos;
use App\Repository\StaffRepos;
use App\Repository\TeacherRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordLinkMail;

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

        $adminUsers = AdminRepos::getAllAdmin();
        $staffUsers = StaffRepos::getAllStaff();
        $customerUsers = CustomerRepos::getAllCustomer();
        $teacherUsers = TeacherRepos::getAllTeacher();

        $user = null;
        $role = '';

        // Kiểm tra admin
        foreach ($adminUsers as $a) {
            if ($a->username === $login && $a->password === sha1($password)) {
                $user = $a;
                $role = 'admin';
                break;
            }
        }

        // Kiểm tra staff (kiểm tra cả username và email)
        if (!$user) {
            foreach ($staffUsers as $s) {
                if (($s->username === $login || $s->email === $login) && Hash::check($password, $s->password)) {
                    $user = $s;
                    $role = 'staff';
                    break;
                }
            }
        }

        // Kiểm tra customer
        if (!$user) {
            foreach ($customerUsers as $c) {
                if ($c->email === $login && Hash::check($password, $c->password)) {
                    $user = $c;
                    $role = 'customer';
                    break;
                }
            }
        }

        // Kiểm tra teacher
        if (!$user) {
            foreach ($teacherUsers as $t) {
                if ($t->email === $login && Hash::check($password, $t->password)) {
                    $user = $t;
                    $role = 'teacher';
                    break;
                }
            }
        }

        if ($user) {
            $displayName = $role === 'admin' || $role === 'staff' ? $user->username : $user->email;
            Session::put('username', $displayName);
            Session::put('role', $role);

            // Chỉ lưu email vào session khi role là teacher
            if ($role === 'teacher') {
                Session::put('email', $user->email);
            }

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
        }

        return redirect()->action([ManualAuthController::class, 'ask'])
            ->withErrors(['msg' => 'Invalid login credentials!']);
    }

    public function signout()
    {
        Session::forget('username');
        Session::forget('role');
        return redirect()->route('ui.index');
    }

    public function showForgotForm()
    {
        return view('product.manualAuth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        $user = null;
        $role = null;

        // Debug: In ra thông tin email configuration
        Log::info('Mail Configuration:', [
            'driver' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'encryption' => config('mail.mailers.smtp.encryption'),
            'username' => config('mail.mailers.smtp.username'),
            'from_address' => config('mail.from.address'),
        ]);

        // Kiểm tra customer
        $customers = CustomerRepos::getAllCustomer();
        foreach ($customers as $c) {
            if ($c->email === $email) {
                $user = $c;
                $role = 'customer';
                break;
            }
        }

        // Nếu không phải customer, kiểm tra teacher
        if (!$user) {
            $teachers = TeacherRepos::getAllTeacher();
            foreach ($teachers as $t) {
                if ($t->email === $email) {
                    $user = $t;
                    $role = 'teacher';
                    break;
                }
            }
        }

        // Nếu không phải teacher, kiểm tra staff
        if (!$user) {
            $staffs = StaffRepos::getAllStaff();
            foreach ($staffs as $s) {
                if ($s->email === $email) {
                    $user = $s;
                    $role = 'staff';
                    break;
                }
            }
        }

        if (!$user) {
            return back()->withErrors(['email' => 'Cannot find account with this email']);
        }

        try {
            // Tạo token ngẫu nhiên
            $token = bin2hex(random_bytes(32));

            // Lưu token và email vào session
            Session::put('password_reset', [
                'email' => $email,
                'token' => $token,
                'role' => $role,
                'created_at' => now()
            ]);

            // Tạo link reset password
            $resetLink = route('password.reset', ['token' => $token]);

            // Debug: In ra thông tin trước khi gửi email
            Log::info('Attempting to send password reset email', [
                'to' => $user->email,
                'token' => $token,
                'reset_link' => $resetLink
            ]);

            // Gửi email chứa link reset password
            Mail::to($user->email)->send(new ResetPasswordLinkMail($user, $resetLink));

        

            // Debug: Ghi log thành công
            Log::info('Password reset email sent successfully');

            return back()->with('status', 'we just send email reset password to your gmail.Please check you mail.');

        } catch (\Exception $e) {
            // Debug: In ra chi tiết lỗi
            Log::error('Failed to send password reset email: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['email' => 'Cannot send email. Detail error: ' . $e->getMessage()]);
        }
    }

    public function showResetForm(Request $request, $token)
    {
        $resetData = Session::get('password_reset');

        if (!$resetData || $resetData['token'] !== $token) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid password reset link.']);
        }

        return view('product.manualAuth.reset-password', [
            'token' => $token,
            'email' => $resetData['email']
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $resetData = Session::get('password_reset');

        if (!$resetData || $resetData['token'] !== $request->token) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Link reset password not suitable.']);
        }

        $email = $resetData['email'];
        $role = $resetData['role'];
        $user = null;
        $hashedPassword = Hash::make($request->password);

        // Tìm user theo role và email
        switch ($role) {
            case 'staff':
                foreach (StaffRepos::getAllStaff() as $s) {
                    if ($s->email === $email) {
                        $user = $s;
                        StaffRepos::update((object) [
                            'id_s' => $s->id_s,
                            'username' => $s->username,
                            'fullname_s' => $s->fullname_s,
                            'phone_s' => $s->phone_s,
                            'email' => $s->email,
                            'password' => $hashedPassword
                        ]);
                        break;
                    }
                }
                break;
            case 'teacher':
                foreach (TeacherRepos::getAllTeacher() as $t) {
                    if ($t->email === $email) {
                        $user = $t;
                        TeacherRepos::update((object) [
                            'id_t' => $t->id_t,
                            'fullname_t' => $t->fullname_t,
                            'phone_t' => $t->phone_t,
                            'email' => $t->email,
                            'password' => $hashedPassword
                        ]);
                        break;
                    }
                }
                break;
            case 'customer':
                foreach (CustomerRepos::getAllCustomer() as $c) {
                    if ($c->email === $email) {
                        $user = $c;
                        CustomerRepos::update((object) [
                            'id_c' => $c->id_c,
                            'fullname_c' => $c->fullname_c,
                            'dob' => $c->dob,
                            'gender' => $c->gender,
                            'phone_c' => $c->phone_c,
                            'email' => $c->email,
                            'address_c' => $c->address_c,
                            'password' => $hashedPassword
                        ]);
                        break;
                    }
                }
                break;
        }

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Account not found.']);
        }

        // Xóa token reset password
        Session::forget('password_reset');

        // Chuyển hướng đến trang thông báo thành công
        return view('product.manualAuth.reset-success');
    }
}
