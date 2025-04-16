<?php

namespace App\Livewire\Karyawan\Mutasi;

use App\Http\Requests\MutationRequest;
use App\Models\Area;
use App\Models\Employee;
use App\Models\Mutation;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditMutasi extends Component
{
    public $id, $date, $employee_id, $from_area_id, $to_area_id;
    public $namaArea;
    public $search = "";
    public function render()
    {
        return view('livewire.karyawan.mutasi.edit-mutasi', [
            'fetchKaryawan' => Employee::all(),
            'fetchArea' => Area::all()
        ]);
    }

    public function mount($id) {
        $data = Mutation::findOrFail($id);
        Gate::authorize('update', $data);
        $this->namaArea = $data->fromArea->name;
        $this->fill($data->only(['id', 'date', 'employee_id', 'from_area_id', 'to_area_id']));
    }

    public function update() {
        $request = new MutationRequest();
        $this->validate($request->rules(), $request->messages());
        Mutation::findOrFail($this->id)->update([
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
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('mutasi.index');
    }
}
