<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bail',
            'newPassword'     => 'required|min:8|different:email|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', //1 thuong 1 hoa 1 so
            'newPassword1'    => 'same:newPassword', //1 thuong 1 hoa 1 so
        ];
    }

    public function messages(): array
    {
        return [
            'required'          => ':attribute không được để trống',
            'min'               => ':attribute phải hơn 8 kí tự',
            'email'             => ':attribute sai định dạng',
            'different'         => ':attribute không được giống email',
            'regex'             => ':attribute phải có 1 chữ hoa và 1 ký tự',
            'unique'            => ':attribute đã tồn tại',
            'max'               => ':attribute quá dài',
            'image'             => ':attribute không đúng định dạng',
            'same'              => ':attribute Không Trùng',
        ];
    }
    public function attributes(): array
    {
        return [
            'username'          => 'tên người dùng',
            'password'          => 'mật khẩu',
            'email'             => 'email',
            'ten_san_pham'      => 'tên sản phẩm',
            'hinh_anh'          => 'hình ảnh',
            'mo_ta'             => 'mô tả',
            'link1'             => 'link tải về',
            'link2'             => 'link dự phòng',
            'newPassword'       => 'Mật Khẩu Mới',
            'newPassword1'      => 'Mật Khẩu Mới',
        ];
    }
}
