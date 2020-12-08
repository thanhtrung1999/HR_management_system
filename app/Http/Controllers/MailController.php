<?php

namespace App\Http\Controllers;

use App\Models\ResetPassword;

class MailController extends Controller
{
    public function getFormReset($id, $token)
    {
        $employee = $this->employeeModel->getEmployeeByToken($token);
        if ($employee->email_verified_at !== null) {
            return redirect('login')->with('error', 'Tài khoản của bạn đã được xác thực');
        }
        return view('emails.reset-password', [
            'id' => $id,
            'token' => $token
        ]);
    }

    public function getFormResetByRoot($id, $token)
    {
        $resetPassword = ResetPassword::where('token', $token)->first();
        if (empty($resetPassword)) {
            return redirect('login')->with('error', 'Đường dẫn đã không còn hiệu lực');
        }
        return view('emails.reset-password-by-root', [
            'id' => $id,
            'token' => $token
        ]);
    }
}
