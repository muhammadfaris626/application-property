<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'nomor_berkas' => 'required',
            'prospective_customer_id' => 'required',
            'type_of_house_id' => 'required',
            'keterangan_rumah' => 'required',
            'status_penjualan' => 'required',
            'status_pengajuan_user' => 'required',
        ];
    }

    public function messages(): array {
        return [
            'tanggal.required' => 'Kolom tanggal wajib diisi.',
            'nomor_berkas.required' => 'Kolom nomor berkas wajib diisi.',
            'prospective_customer_id.required' => 'Kolom calon user wajib diisi.',
            'type_of_house_id.required' => 'Kolom jenis rumah wajib diisi.',
            'keterangan_rumah.required' => 'Kolom keterangan rumah wajib diisi.',
            'status_penjualan.required' => 'Kolom status penjualan wajib diisi.',
            'status_pengajuan_user.required' => 'Kolom status pengajuan user wajib diisi.',
        ];
    }
}
