<?php

namespace App\Livewire\Penjualan\CalonUser;

use App\Http\Requests\ProspectiveCustomerRequest;
use App\Models\Employee;
use App\Models\ProspectiveCustomer;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateCalonUser extends Component
{
    public $date, $identification_number, $name, $address, $whatsapp_number, $email, $employee_id, $action;
    public $fetchKaryawan;
    public $search = "";
    public function mount() {
        $this->fetchKaryawan = Employee::where('active', 1)->get();
    }
    public function render()
    {
        Gate::authorize('create', ProspectiveCustomer::class);
        return view('livewire.penjualan.calon-user.create-calon-user');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new ProspectiveCustomerRequest();
        $this->validate($request->rules(), $request->messages());
        ProspectiveCustomer::create([
            'date' => $this->date,
            'identification_number' => $this->identification_number,
            'name' => $this->name,
            'address' => $this->address,
            'whatsapp_number' => "+62" . $this->whatsapp_number,
            'email' => $this->email,
            'employee_id' => $this->employee_id,
            'area_id' => User::where('employee_id', $this->employee_id)->first()->area_id
        ]);
        $this->dispatch('resetDropdown');
        $this->reset(['date', 'identification_number', 'name', 'address', 'whatsapp_number', 'email', 'employee_id']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('calon-user.index');
        }
    }
}
