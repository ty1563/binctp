<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PanelGameCreateRequest extends FormRequest
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
            'thoi_gian' => 'required|integer|min:0',
            'max_devices' => 'required|integer|min:0',
            'number' => 'required|integer|min:0',
            'game' => 'required',
        ];
    }
}
