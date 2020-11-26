<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditEmployeeRequest extends FormRequest
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
            'email' => 'required|email|unique:employees,email,'.$this->employee,
            'password' => 'nullable|min:3',
            'department_id' => 'required|gt:0',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Trường này là bắt buộc',
            'last_name.required' => 'Trường này là bắt buộc',
            'email.required' => 'Trường này là bắt buộc',
            'email.email' => 'Email sai định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.min' => 'Password lớn hơn 3 ký tự',
            'department_id.required' => 'Vui lòng chọn phòng ban làm việc',
            'department_id.gt' => 'Vui lòng chọn phòng ban làm việc',
        ];
    }
}
