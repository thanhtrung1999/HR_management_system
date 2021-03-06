<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthLogout
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('root')->check()) {
            session()->flash('error', 'Vui lòng đăng xuất để trở lại trang đăng nhập');
            return redirect()->route('employees.index');
        } elseif (Auth::guard('employees')->check()) {
            session()->flash('error', 'Vui lòng đăng xuất để trở lại trang đăng nhập');
            return redirect('/');
        } else {
            return $next($request);
        }
    }
}
