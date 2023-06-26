<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SinhVienCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'mssv' => 'required',
            'name' => 'required',
            'class_id' => 'required',
            'thumb' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'mssv.required' => 'Vui lòng nhập mã sinh viên',
            'name.required' => 'Tên sinh viên không được trống',
            'class_id.required' => 'Lớp môn học không được trống',
            'thumb.required' => 'Ảnh đại diện không được trống',
        ];
    }
}
