<?php

namespace App\Livewire\Penjualan\CalonUser;

use App\Http\Requests\ProspectiveCustomerRequest;
use App\Models\Employee;
use App\Models\ProspectiveCustomer;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditCalonUser extends Component
{
    public $id, $date, $identification_number, $name, $address, $whatsapp_number, $email, $employee_id;
    public $fetchKaryawan;
    public $search = "";
    public function mount($id) {
        $this->fetchKaryawan = Employee::where('active', 1)->get();
        $this->id = $id;
        $data = ProspectiveCustomer::findOrFail($id);
        Gate::authorize('update', $data);
        $this->date = $data->date;
        $this->identification_number = $data->identification_number;
        $this->name = $data->name;
        $this->address = $data->address;
        $this->whatsapp_number = str_replace("+62", "", $data->whatsapp_number);
        $this->email = $data->email;
        $this->employee_id = $data->employee_id;
    }
    public function render()
    {
        return view('livewire.penjualan.calon-user.edit-calon-user');
    }

    public function update() {
        $validatedData = $this->validate([
            'date' => 'required',
            'identification_number' => 'required',
            'name' => 'required',
            'address' => 'required',
            'whatsapp_number' => 'required',
            'email' => 'required|email|unique:prospective_customers,email,' . $this->id,
            'employee_id' => 'required',
        ], [
            'date.required' => 'Kolom tanggal wajib diisi.',
            'identification_number.required' => 'Kolom nomor induk kependudukan wajib diisi.',
            'name.required' => 'Kolom nama wajib diisi.',
            'address.required' => 'Kolom alamat wajib diisi.',
            'whatsapp_number.required' => 'Kolom nomor whatsapp wajib diisi.',
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Harap gunakan format email yang benar.',
            'email.unique' => 'Email sudah terdaftar, harap gunakan email yang berbeda.'
        ]);
        ProspectiveCustomer::findOrFail($this->id)->update([
            'date' => $validatedData['date'],
            'identification_number' => $validatedData['identification_number'],
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'whatsapp_number' => "+62" . $validatedData['whatsapp_number'],
            'email' => $validatedData['email'],
            'employee_id' => $validatedData['employee_id'],
            'area_id' => User::where('employee_id', $this->employee_id)->first()->area_id
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('calon-user.index');
    }
}
