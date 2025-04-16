<?php

namespace App\Livewire\Database\Karyawan;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateKaryawan extends Component
{
    public $identification_number, $name, $address, $place_of_birth, $date_of_birth, $whatsapp_number, $email, $action;
    public function render()
    {
        Gate::authorize('create', Employee::class);
        return view('livewire.database.karyawan.create-karyawan');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new EmployeeRequest();
        $this->validate($request->rules(), $request->messages());
        $create = Employee::create([
            'identification_number' => $this->identification_number,
            'name' => $this->name,
            'address' => $this->address,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => $this->date_of_birth,
            'whatsapp_number' => "+62" . $this->whatsapp_number,
            'email' => $this->email,
        ]);
        User::create([
            'employee_id' => $create->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make('12345678')
        ]);
        $this->reset(['identification_number', 'name', 'address', 'place_of_birth', 'date_of_birth', 'whatsapp_number', 'email']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('karyawan.index');
        }
    }
}
