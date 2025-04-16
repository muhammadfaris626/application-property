<?php

namespace App\Livewire\Pengaturan\Perizinan;

use App\Http\Requests\PerizinanRequest;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditPerizinan extends Component
{
    public $id, $name;
    public function mount($id) {
        $this->id = $id;
        $data = Permission::findOrFail($id);
        Gate::authorize('update', $data);
        $this->name = $data->name;
    }
    public function render()
    {
        return view('livewire.pengaturan.perizinan.edit-perizinan');
    }

    public function update() {
        $request = new PerizinanRequest();
        $this->validate($request->rules(), $request->messages());
        Permission::findOrFail($this->id)->update([
            'name' => $this->name
        ]);
        session()->flash('success', 'Data berhasil diperbarui.');
        return to_route('perizinan.index');
    }
}
