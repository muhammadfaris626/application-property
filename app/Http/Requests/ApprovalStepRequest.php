<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalStepRequest extends FormRequest
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
            'step' => ['required'],
            'position_id' => ['required'],
            'type_of_agreement' => ['required']
        ];
    }

    public function messages(): array {
        return [
            'step.required' => 'Kolom nomor urutan wajib diisi.',
            'position_id.required' => 'Kolom jabatan wajib diisi.',
            'type_of_agreement.required' => 'Kolom jenis persetujuan wajib diisi.'
        ];
    }
}
