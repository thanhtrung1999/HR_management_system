<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:root')->except('logout');
        $this->middleware('guest:employee')->except('logout');
    }*/

    public function login()
    {
        return view('login.login');
    }

    public function postLogin(LoginRequest $request)
    {
        if ($request->type == 'root') {
            $checkLogin = Auth::guard('root')->attempt(['email'=>$request->email, 'password'=>$request->password]);
            if ($checkLogin) {
                return redirect('root/employees')->with('success', 'Đăng nhập thành công');
            } else {
                return redirect('login')->withInput()->with('error', 'Sai email hoặc password');
            }
        } else {
            $checkLogin = Auth::guard('employees')->attempt(['email'=>$request->email, 'password'=>$request->password]);
            if ($checkLogin) {
                return redirect('/')->with('success', 'Đăng nhập thành công');
            } else {
                return redirect('login')->withInput()->with('error', 'Sai email hoặc password');
            }
        }
    }

    public function logout()
    {
        if (Auth::guard('root')->check()) {
            Auth::guard('root')->logout();
        } else {
            Auth::guard('employees')->logout();
        }
        return redirect('login')->with('success', 'Đăng xuất thành công');
    }
}
