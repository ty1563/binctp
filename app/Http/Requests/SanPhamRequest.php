<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SanPhamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bail',
            'ten_san_pham'      => 'required|unique:san_phams,ten_san_pham,except,id',
            'hinh_anh'          => 'required',
            'mo_ta'             => 'required|max:200',
            'link1'             => 'required|max:200',
            'link2'             => 'required|max:200',
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
        ];
    }
}
