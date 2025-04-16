<?php

namespace App\Livewire\Karyawan\Pemberhentian;

use App\Http\Requests\TerminationRequest;
use App\Models\Employee;
use App\Models\Termination;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditPemberhentian extends Component
{
    public $id, $date, $employee_id;
    public $fetchKaryawan = [];
    public $search = "";
    public function mount($id) {
        $data = Termination::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'date', 'employee_id']));
        $this->fetchKaryawan = Employee::where('active', 1)
            ->orWhere('id', $this->employee_id)
            ->get();
    }
    public function render()
    {
        return view('livewire.karyawan.pemberhentian.edit-pemberhentian');
    }

    public function update() {
        $request = new TerminationRequest();
        $this->validate($request->rules(), $request->messages());
        $check = Termination::findOrFail($this->id);

        if ($check->employee_id != $this->employee_id) {
            Employee::where('id', $check->employee_id)->update(['active' => 1]);
            User::where('employee_id', $check->employee_id)->update(['active' => 1]);
            Employee::where('id', $this->employee_id)->update(['active' => 0]);
            User::where('employee_id', $this->employee_id)->update(['active' => 0]);
        }
        $check->update([
            'date' => $this->date,
            'employee_id' => $this->employee_id
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('pemberhentian.index');
    }
}
