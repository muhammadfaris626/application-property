<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StructureRequest extends FormRequest
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
            'employee_id' => ['required'],
            'position_id' => ['required'],
            'area_id' => ['required'],
            'employee_number' => ['required']
        ];
    }

    public function messages(): array {
        return [
            'employee_id.required' => 'Kolom karyawan wajib diisi.',
            'position_id.required' => 'Kolom jabatan wajib diisi.',
            'area_id.required' => 'Kolom area wajib diisi.',
            'employee_number.required' => 'Kolom nomor identitas kepegawaian wajib diisi.'
        ];
    }
}
