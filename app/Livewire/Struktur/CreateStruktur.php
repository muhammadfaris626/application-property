<?php

namespace App\Livewire\Struktur;

use App\Http\Requests\StructureRequest;
use App\Models\Area;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateStruktur extends Component
{
    public $employee_id, $position_id, $area_id, $employee_number, $action;
    public $search = "";
    public function render()
    {
        Gate::authorize('create', Structure::class);
        $existingEmployeeIds = Structure::pluck('employee_id')->toArray();
        return view('livewire.struktur.create-struktur', [
            'fetchKaryawan' => Employee::whereNotIn('id', $existingEmployeeIds)->get(),
            'fetchJabatan' => Position::all(),
            'fetchArea' => Area::all()
        ]);
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new StructureRequest();
        $this->validate($request->rules(), $request->messages());
        Structure::create([
            'employee_id' => $this->employee_id,
            'position_id' => $this->position_id,
            'area_id' => $this->area_id,
            'employee_number' => $this->employee_number
        ]);
        User::where('employee_id', $this->employee_id)->update([
            'area_id' => $this->area_id,
            'active' => 1
        ]);
        Employee::where('id', $this->employee_id)->update([
            'active' => 1
        ]);

        $this->dispatch('resetDropdown');
        $this->reset(['employee_id', 'position_id', 'area_id', 'employee_number']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('struktur.index');
        }
    }
}
