<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function verifyAccount($id, $token)
    {
        $employee = $this->employeeModel->getEmployeeByToken($token);
        if($employee->email_verified_at !== null){
            return redirect()->route('login')->with('error','Tài khoản của bạn đã được xác thực');
        }
        $employee->email_verified_at = Carbon::now();
        $employee->save();
        return redirect('login')->with('success', 'Xác thực tài khoản thành công');
    }
}
