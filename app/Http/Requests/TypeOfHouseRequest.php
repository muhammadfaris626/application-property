<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeOfHouseRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'area_id' => ['required'],
            'name' => ['required'],
            'price' => ['required']
        ];
    }

    public function messages(): array {
        return [
            'area_id.required' => 'Kolom nama area wajib diisi.',
            'name.required' => 'Kolom jenis rumah wajib diisi.',
            'price.required' => 'Kolom harga wajib diisi.'
        ];
    }
}
