<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|min:3',
            'confirm_password' => 'required|min:3|same:new_password',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Trường này là bắt buộc',
            'new_password.required' => 'Trường này là bắt buộc',
            'new_password.min' => 'Lớn hơn 3 ký tự',
            'confirm_password.required' => 'Trường này là bắt buộc',
            'confirm_password.min' => 'Lớn hơn 3 ký tự',
            'confirm_password.same' => 'Confirm password phải giống New password'
        ];
    }
}
