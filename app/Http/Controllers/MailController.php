<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;

class MailController extends Controller
{
    public function verifyAccount($id, $token){
        $employee = $this->employeeModel->getEmployeeByToken($token);
        if($employee->email_verified_at !== null){
            return redirect('login')->with('error','Tài khoản của bạn đã được xác thực');
        }
        return view('emails.reset-password', [
            'id' => $id,
            'token' => $token
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request, $id, $token){
        $employee = $this->employeeModel->getEmployeeByToken($token);
        if (!Hash::check($request['current_password'], $employee->password)){
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không đúng');
        }
        $employee->password = Hash::make($request['new_password']);
        $employee->email_verified_at = Carbon::now();
        $employee->save();

        return redirect('login')->with('success','Xác nhận đổi mật khẩu thành công');
    }
}
