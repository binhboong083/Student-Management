<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LopQuanLyCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'malop' => 'required',
            'tenlop' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'malop.required' => 'Không được để trống Mã lớp quản lý',
            'tenlop.required' => 'Không được để trống Tên lớp quản lý',
        ];
    }
}