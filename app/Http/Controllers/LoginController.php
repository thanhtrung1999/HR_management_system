<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:root')->except('logout');
        $this->middleware('guest:employee')->except('logout');
    }

    public function login(){
        return view('login.login');
    }

    public function postLogin(LoginRequest $request){
        if($request->type == 'root'){
            $check_login = Auth::guard('root')->attempt(['username'=>$request->username, 'password'=>$request->password]);
            if($check_login){
                session()->flash('success', 'Đăng nhập thành công');
                return redirect('root/employees');
            } else {
                session()->flash('error', 'Sai email hoặc password');
                return redirect('login')->withInput();
            }
        } else {
            dd('Đăng nhập với tự cách nhân viên');
            //Dùng Auth của employee để login
        }
    }

    public function logout(){
        Auth::guard('root')->logout();
        session()->flash('success', 'Đăng xuất thành công');
        return redirect('login');
    }
}
