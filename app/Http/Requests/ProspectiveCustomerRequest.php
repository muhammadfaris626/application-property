<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProspectiveCustomerRequest extends FormRequest
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
            'identification_number' => ['required'],
            'name' => ['required'],
            'address' => ['required'],
            'whatsapp_number' => ['required'],
            'email' => ['required', 'email', 'unique:prospective_customers,email'],
            'employee_id' => ['required']
        ];
    }

    public function messages(): array {
        return [
            'date.required' => 'Kolom tanggal wajib diisi.',
            'identification_number.required' => 'Kolom nomor induk kependudukan wajib diisi.',
            'name.required' => 'Kolom nama wajib diisi.',
            'address.required' => 'Kolom alamat wajib diisi.',
            'whatsapp_number.required' => 'Kolom nomor whatsapp wajib diisi.',
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Harap gunakan format email yang benar.',
            'email.unique' => 'Email sudah terdaftar, harap gunakan email yang berbeda.'
        ];
    }
}
