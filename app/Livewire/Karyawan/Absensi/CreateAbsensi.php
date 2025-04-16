<?php

namespace App\Livewire\Karyawan\Absensi;

use App\Http\Requests\AbsensiRequest;
use App\Models\Absensi;
use App\Models\Employee;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateAbsensi extends Component
{
    public $employee_id, $date, $check_in, $check_out, $action;
    public $search = "";
    public $fetchKaryawan;

    public function mount() {
        $this->fetchKaryawan = Employee::where('active', 1)->get();
    }

    public function render()
    {
        Gate::authorize('create', Absensi::class);
        return view('livewire.karyawan.absensi.create-absensi');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new AbsensiRequest();
        $this->validate($request->rules(), $request->messages());
        Absensi::create([
            'employee_id' => $this->employee_id,
            'date' => $this->date,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out
        ]);
        $this->dispatch('resetDropdown');
        $this->reset(['employee_id', 'date', 'check_in', 'check_out']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('absensi.index');
        }
    }
}
