<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuiDanhGiaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required',
            'noi_dung' => 'required|max:300',
            'id_san_pham' => 'required|exists:san_phams,id',
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'exists' => ':attribute Không Tồn Tại',
            'max' => ':attribute Quá Dài',
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Tên Người Dùng',
            'noi_dung' => 'Nội Dung Đánh Giá',
            'id_san_pham' => 'Sản Phẩm',
        ];
    }
}
