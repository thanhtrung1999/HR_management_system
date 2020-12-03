<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\ResetPassword;

class ResetPasswordController extends Controller
{
    public function changePassword(ResetPasswordRequest $request, $id, $token){
        $employee = $this->employeeModel->getEmployeeByToken($token);
        if (!Hash::check($request['current_password'], $employee->password)){
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không đúng');
        }
        $employee->password = Hash::make($request['new_password']);
        $employee->email_verified_at = Carbon::now();
        $employee->save();

        return redirect('login')->with('success','Xác nhận đổi mật khẩu thành công');
    }

    public function resetPasswordByRoot(Request $request){
        if(!empty($request['reset_password'])){
            foreach ($request['reset_password'] as $employeeId){
                $employee = $this->employeeModel->getEmployeeById($employeeId);
                $email = $employee->email;
                $password = Str::random(8);
                $token = md5((string) Str::uuid());

                $employee->password = Hash::make($password);
                $employee->save();
                $resetPassword = ResetPassword::where('email', $employee->email)->first();
                if(empty($resetPassword)){
                    $resetPasswordModel = new ResetPassword();
                    $resetPasswordModel->email = $email;
                    $resetPasswordModel->token = $token;
                    $resetPasswordModel->save();
                } else {
                    $resetPassword->email = $email;
                    $resetPassword->token = $token;
                    $resetPassword->save();
                }

                $data = [
                    'email' => $email,
                    'password' => $password,
                    'url' => route('reset-password', ['id'=>$employeeId,'token'=>$token])
                ];
                dispatch(new \App\Jobs\SendMailResetPassword($data));
            }
            return redirect()->back()->with('success','Reset password thành công');
        } else {
            return redirect()->back()->with('error','Chọn nhân viên để Reset password');
        }

    }

    public function sendDataResetPass(ResetPasswordRequest $request, $id, $token){
        $employee = $this->employeeModel->getEmployeeById($id);
        if (!Hash::check($request['current_password'], $employee->password)){
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không đúng');
        }
        $resetPassword = ResetPassword::where('email', $employee->email)->first();
        $resetPassword->token = null;
        $resetPassword->created_at = Carbon::now();
        $resetPassword->save();
        $employee->password = Hash::make($request['new_password']);
        $employee->save();

        return redirect('login')->with('success','Xác nhận đổi mật khẩu thành công');
    }
}
