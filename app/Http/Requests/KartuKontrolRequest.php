<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KartuKontrolRequest extends FormRequest
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
            'tanggal' => 'required',
            'customer_id' => 'required'
        ];
    }

    public function messages(): array {
        return [
            'tanggal.required' => 'Kolom tanggal wajib diisi.',
            'customer_id.required' => 'Kolom nama user wajib diisi.'
        ];
    }
}
