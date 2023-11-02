<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignKhachCheck extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bail',
            'username' => 'required|min:8|max:20|unique:khach_hangs,username,except,id',
            'password' => 'required|min:8|different:email|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', //1 thuong 1 hoa 1 so
            'email' => 'required|email|unique:khach_hangs,email,except,id',
        ];
    }
    public function messages() : array
    {
        return [
            'required' => ':attribute không được để trống',
            'min' => ':attribute phải hơn 8 kí tự',
            'email' => ':attribute sai định dạng',
            'different' => ':attribute không được giống email',
            'regex' => ':attribute phải có 1 chữ hoa và 1 ký tự',
            'unique' => ':attribute đã tồn tại',
        ];
    }
    public function attributes() :array
    {
        return [
            'username' => 'tên người dùng',
            'password' => 'mật khẩu',
            'email' => 'email',
        ];
    }
}
