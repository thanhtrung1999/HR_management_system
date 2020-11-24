<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:3',
            'type' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Không được để trống',
            'email.email' => 'Email sai định dạng',
            'password.required' => 'Không được để trống',
            'password.min' => 'Password không được nhỏ hơn 3 ký tự',
            'type.required' => 'Hãy chọn Root hoặc Nhân viên'
        ];
    }
}
