<?php

namespace App\Livewire\Struktur;

use App\Http\Requests\StructureRequest;
use App\Models\Area;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditStruktur extends Component
{
    public $id, $employee_id, $position_id, $area_id, $employee_number;
    public $search = "";
    public function render()
    {
        $existingEmployeeIds = Structure::pluck('employee_id')->toArray();
        $structure = isset($this->id) ? Structure::find($this->id) : null;
        return view('livewire.struktur.edit-struktur', [
            'fetchKaryawan' => Employee::whereNotIn('id', $existingEmployeeIds)
                ->when($structure, function ($query) use ($structure) {
                    return $query->orWhere('id', $structure->employee_id);
                })
                ->get(),
            'fetchJabatan' => Position::all(),
            'fetchArea' => Area::all()
        ]);
    }

    public function mount($id) {
        $data = Structure::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'employee_id', 'position_id', 'area_id', 'employee_number']));
    }

    public function update() {
        $request = new StructureRequest();
        $this->validate($request->rules(), $request->messages());
        $check = Structure::findOrFail($this->id);
        if ($check->employee_id != $this->employee_id) {
            Employee::where('id', $check->employee_id)->update(['active' => 0]);
            User::where('employee_id', $check->employee_id)->update(['active' => 0, 'area_id' => null]);
            Employee::where('id', $this->employee_id)->update(['active' => 1]);
            User::where('employee_id', $this->employee_id)->update(['area_id' => $this->area_id, 'active' => 1]);
        } else {
            User::where('employee_id', $this->employee_id)->update(['area_id' => $this->area_id]);
        }
        $check->update([
            'employee_id' => $this->employee_id,
            'position_id' => $this->position_id,
            'area_id' => $this->area_id,
            'employee_number' => $this->employee_number
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('struktur.index');
    }
}
