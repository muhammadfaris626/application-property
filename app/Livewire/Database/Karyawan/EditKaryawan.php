<?php

namespace App\Livewire\Database\Karyawan;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditKaryawan extends Component
{
    public $id, $identification_number, $name, $address, $place_of_birth, $date_of_birth, $whatsapp_number, $email, $active;
    public function render()
    {
        return view('livewire.database.karyawan.edit-karyawan');
    }

    public function mount($id) {
        $this->id = $id;
        $data = Employee::findOrFail($id);
        Gate::authorize('update', $data);
        $this->identification_number = $data->identification_number;
        $this->name = $data->name;
        $this->address = $data->address;
        $this->place_of_birth = $data->place_of_birth;
        $this->date_of_birth = $data->date_of_birth;
        $this->whatsapp_number = str_replace("+62", "", $data->whatsapp_number);
        $this->email = $data->email;

    }

    public function update() {
        $validatedData = $this->validate([
            'identification_number' => 'required',
            'name' => 'required',
            'address' => 'required',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required|date',
            'whatsapp_number' => 'required',
            'email' => 'required|email|unique:employees,email,' . $this->id,
        ], [
            'identification_number.required' => 'Kolom nomor induk kependudukan wajib diisi.',
            'name.required' => 'Kolom nama wajib diisi.',
            'address.required' => 'Kolom alamat wajib diisi.',
            'place_of_birth.required' => 'Kolom tempat lahir wajib diisi.',
            'date_of_birth.required' => 'Kolom tanggal lahir wajib diisi.',
            'whatsapp_number.required' => 'Kolom nomor whatsapp wajib diisi.',
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Harap gunakan format email yang benar.',
            'email.unique' => 'Email sudah terdaftar, harap gunakan email yang berbeda.'
        ]);
        Employee::findOrFail($this->id)->update([
            'identification_number' => $validatedData['identification_number'],
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'place_of_birth' => $validatedData['place_of_birth'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'whatsapp_number' => "+62" . $validatedData['whatsapp_number'],
            'email' => $validatedData['email']
        ]);
        $user = User::where('employee_id', $this->id)->first();
        $user->update([
            'name' => $this->name,
            'email' => $this->email
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('karyawan.index');
    }
}
