<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeMailRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'new' => 'required|email|min:8',
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute Bắt Buộc Phải Nhập',
            'email'    => ':attribute Sai Định Dạng',
            'min'      => ':attribute Phải Trên 8 Ký Tự',
        ];
    }
    public function attributes()
    {
        return [
            'new' => 'E-mail Mới',
        ];
    }
}
