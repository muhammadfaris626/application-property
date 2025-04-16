<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOfMaterialRequest extends FormRequest
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
            'invoice_number' => ['required', 'unique:purchase_of_materials,invoice_number'],
            'date' => ['required'],
            'supplier_id' => ['required'],
            'employee_id' => ['required']
        ];
    }

    public function messages(): array {
        return [
            'invoice_number.required' => 'Kolom nomor faktur wajib diisi.',
            'invoice_number.unique' => 'Nomor faktur sudah ada.',
            'date.required' => 'Kolom tanggal wajib diisi.',
            'supplier_id.required' => 'Kolom supplier wajib diisi.',
            'employee_id.required' => 'Kolom penerima barang wajib diisi.'
        ];
    }
}
