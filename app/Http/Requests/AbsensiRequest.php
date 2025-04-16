<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsensiRequest extends FormRequest
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
            'employee_id' => 'required',
            'date' => 'required',
            'check_in' => 'required',
            'check_out' => 'required'
        ];
    }

    public function messages(): array {
        return [
            'employee_id.required' => 'Kolom karyawan wajib diisi.',
            'date.required' => 'Kolom tanggal wajib diisi.',
            'check_in.required' => 'Kolom jam masuk wajib diisi.',
            'check_out.required' => 'Kolom jam keluar wajib diisi.'
        ];
    }
}
