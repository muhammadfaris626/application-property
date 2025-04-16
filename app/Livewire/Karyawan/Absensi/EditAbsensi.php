<?php

namespace App\Livewire\Karyawan\Absensi;

use App\Http\Requests\AbsensiRequest;
use App\Models\Absensi;
use App\Models\Employee;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditAbsensi extends Component
{
    public $id, $employee_id, $date, $check_in, $check_out;
    public $search = "";
    public $fetchKaryawan;
    public function mount($id) {
        $data = Absensi::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'employee_id', 'date', 'check_in', 'check_out']));
        $this->fetchKaryawan = Employee::where('active', 1)->get();
    }
    public function render()
    {
        return view('livewire.karyawan.absensi.edit-absensi');
    }

    public function update() {
        $request = new AbsensiRequest();
        $this->validate($request->rules(), $request->messages());
        Absensi::findOrFail($this->id)->update([
            'employee_id' => $this->employee_id,
            'date' => $this->date,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('absensi.index');
    }
}
