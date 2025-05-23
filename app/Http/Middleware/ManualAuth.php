<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManualAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $out = new \Symfony\Component\Console\Output\ConsoleOutput();

        if (!Session::has('username')){
//            session ko cos username thì in ra unauthenticated rồi quay trở lại trang auth.ask
            $out->writeln('unauthenticated');
            return redirect()->route('auth.ask');
        } else {
        }

        return $next($request);
    }
}
