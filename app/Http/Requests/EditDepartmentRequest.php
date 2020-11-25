<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditDepartmentRequest extends FormRequest
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
            'department_name' => 'required|unique:departments,name,'.$this->id,
            'manager' => 'required|gt:0'
        ];
    }

    public function messages()
    {
        return [
            'department_name.required' => 'Trường này là bắt buộc',
            'department_name.unique' => 'Phòng ban đã tồn tại',
            'manager.required' => 'Trường này là bắt buộc',
            'manager.gt' => 'Trường này là bắt buộc'
        ];
    }
}
