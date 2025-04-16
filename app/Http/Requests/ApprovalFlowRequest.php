<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalFlowRequest extends FormRequest
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
            'name' => ['required'],
            'model_type' => ['required'],
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Kolom nama persetujuan wajib diisi.',
            'model_type.required' => 'Kolom nama model wajib diisi.'
        ];
    }
}
