<?php

namespace App\Livewire\Karyawan\Mutasi;

use App\Http\Requests\MutationRequest;
use App\Models\Area;
use App\Models\Employee;
use App\Models\Mutation;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateMutasi extends Component
{
    public $date, $employee_id, $from_area_id, $to_area_id, $action;
    public $fetchKaryawan = [];
    public $fetchArea = [];
    public $namaArea = '';
    public $search = "";

    public function mount() {
        $this->fetchKaryawan = Employee::where('active', 1)->get();
        $this->fetchArea = Area::all();
    }

    public function updatedEmployeeId()
    {
        // Ambil area_id dari karyawan yang dipilih
        $tampilkanStruktur = Structure::where('employee_id', $this->employee_id)->first();
        // $this->from_area_id = $tampilkanStruktur ? $tampilkanStruktur->area_id : null;
        // $this->namaArea = $tampilkanStruktur->area->name;
        if ($tampilkanStruktur) {
            $this->from_area_id = $tampilkanStruktur->area_id;
            $this->namaArea = $tampilkanStruktur->area->name;
        } else {
            $this->from_area_id = null;
            $this->namaArea = null;
            LivewireAlert::text('Silahkan masukkan karyawan ke dalam struktur dulu.')->error()->toast()->position('top-end')->show();
        }
    }

    public function render()
    {
        Gate::authorize('create', Mutation::class);
        return view('livewire.karyawan.mutasi.create-mutasi');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new MutationRequest();
        $this->validate($request->rules(), $request->messages());

        Mutation::create([
            'date' => $this->date,
            'employee_id' => $this->employee_id,
            'from_area_id' => $this->from_area_id,
            'to_area_id' => $this->to_area_id
        ]);

        Structure::where('employee_id', $this->employee_id)->update([
            'area_id' => $this->to_area_id
        ]);

        User::where('employee_id', $this->employee_id)->update([
            'area_id' => $this->to_area_id
        ]);

        // Reset form & dropdown
        $this->dispatch('resetDropdown');
        $this->reset(['date', 'employee_id', 'from_area_id', 'to_area_id', 'namaArea']);

        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('mutasi.index');
        }
    }

}
