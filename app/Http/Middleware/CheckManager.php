<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckManager
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
        if (Auth::guard('employees')->user()->user_type == 1) {
            return $next($request);
        } else {
            return redirect('/')->with('error', 'Bạn không phải trưởng phòng');
        }
    }
}
