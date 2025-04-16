<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengajuanInvoiceRequest extends FormRequest
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
            'date' => ['required'],
            'employee_id' => ['required'],
            'price' => ['required'],
            'desc' => ['required']
        ];
    }

    public function messages(): array {
        return [
            'date.required' => 'Kolom tanggal wajib diisi.',
            'employee_id.required' => 'Kolom penanggung jawab wajib diisi.',
            'price.required' => 'Kolom harga wajib diisi.',
            'desc.required' => 'Kolom keterangan wajib diisi.'
        ];
    }
}
