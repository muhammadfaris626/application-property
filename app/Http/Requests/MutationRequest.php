<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MutationRequest extends FormRequest
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
            'from_area_id' => ['required'],
            'to_area_id' => ['required']
        ];
    }

    public function messages(): array {
        return [
            'date.required' => 'Kolom tanggal wajib diisi.',
            'employee_id.required' => 'Kolom karyawan wajib diisi.',
            'from_area_id.required' => 'Kolom area sebelumnya wajib diisi.',
            'to_area_id.required' => 'Kolom mutasi ke wajib diisi.'
        ];
    }
}
