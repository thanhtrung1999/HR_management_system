<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:root')->except('logout');
        $this->middleware('guest:employee')->except('logout');
    }*/

    public function login(){
        return view('login.login');
    }

    public function postLogin(LoginRequest $request){
        if($request->type == 'root'){
            $check_login = Auth::guard('root')->attempt(['email'=>$request->email, 'password'=>$request->password]);
            if($check_login){
                session()->flash('success', 'Đăng nhập thành công');
                return redirect('root/employees');
            } else {
                session()->flash('error', 'Sai email hoặc password');
                return redirect('login')->withInput();
            }
        } else {
            $check_login = Auth::guard('employees')->attempt(['email'=>$request->email, 'password'=>$request->password]);
            if($check_login){
                session()->flash('success', 'Đăng nhập thành công');
                return redirect('/');
            } else {
                session()->flash('error', 'Sai email hoặc password');
                return redirect('login')->withInput();
            }
        }
    }

    public function logout(){
        if (Auth::guard('root')->check()){
            Auth::guard('root')->logout();
        } else {
            Auth::guard('employees')->logout();
        }
        session()->flash('success', 'Đăng xuất thành công');
        return redirect('login');
    }
}
