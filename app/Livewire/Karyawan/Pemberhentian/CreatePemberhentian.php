<?php

namespace App\Livewire\Karyawan\Pemberhentian;

use App\Http\Requests\TerminationRequest;
use App\Models\Employee;
use App\Models\Termination;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreatePemberhentian extends Component
{
    public $date, $employee_id, $action;
    public $fetchKaryawan = [];
    public $search = "";
    public function mount() {
        $this->fetchKaryawan = Employee::where('active', 1)->get();
    }
    public function render()
    {
        Gate::authorize('create', Termination::class);
        return view('livewire.karyawan.pemberhentian.create-pemberhentian');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new TerminationRequest();
        $this->validate($request->rules(), $request->messages());
        Termination::create([
            'date' => $this->date,
            'employee_id' => $this->employee_id
        ]);
        User::where('employee_id', $this->employee_id)->update([
            'active' => 0
        ]);
        Employee::where('id', $this->employee_id)->update([
            'active' => 0
        ]);
        $this->dispatch('resetDropdown');
        $this->reset(['date', 'employee_id']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('pemberhentian.index');
        }
    }
}
