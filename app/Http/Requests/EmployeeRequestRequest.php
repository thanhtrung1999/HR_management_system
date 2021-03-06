<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequestRequest extends FormRequest
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
            'content' => 'required',
            'start_at' => 'required',
            'end_at' => 'required|after:start_at'
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Trường này là bắt buộc',
            'start_at.required' => 'Trường này là bắt buộc',
            'end_at.required' => 'Trường này là bắt buộc',
        ];
    }
}
