<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'profile_img' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp',
            'gender' => 'required|in:0,1',
            'birthday' => 'nullable|date_format:Y-m-d',
            'phone' => 'nullable|numeric|regex:/[0-9]{10}/|digits:10',
            'address' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Trường này là bắt buộc',
            'last_name.required' => 'Trường này là bắt buộc',
            'profile_img.mimes' => 'File sai định dạng',
            'birthday.date_format' => 'Ngày sinh sai định dạng',
            'phone.numeric' => 'Số điện thoại không hợp lệ',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'phone.digits' => 'Số điện thoại tối đa 10 số'
        ];
    }
}
