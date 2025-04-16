<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PendapatanRequest extends FormRequest
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
            'type_of_income_id' => 'required',
            'customer_id' => 'required',
            'keterangan' => '',
            'total' => 'required',
        ];
    }

    public function messages(): array {
        return [
            'tanggal.required' => 'Kolom tanggal wajib diisi.',
            'type_of_income_id.required' => 'Kolom jenis pemasukan wajib diisi.',
            'customer_id.required' => 'Kolom user wajib diisi.',
            'total.required' => 'Kolom total wajib diisi.',
        ];
    }
}
