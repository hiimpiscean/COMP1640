<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Session::has('username')) {
            return redirect()->route('auth.ask');
        }

        $userRole = Session::get('role');
        
        // Kiểm tra nếu role của user nằm trong danh sách roles được phép
        if (!in_array($userRole, $roles)) {
            return redirect()->route('ui.index')
                ->with('error', 'Bạn không có quyền truy cập trang này!');
        }
        
        return $next($request);
    }
}