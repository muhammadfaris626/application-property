<?php

namespace App\Livewire\Database\Jabatan;

use App\Http\Requests\PositionRequest;
use App\Models\Position;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditJabatan extends Component
{
    public $id, $name;
    public function render()
    {
        return view('livewire.database.jabatan.edit-jabatan');
    }

    public function mount($id) {
        $data = Position::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'name']));
    }

    public function update() {
        $request = new PositionRequest();
        $this->validate($request->rules(), $request->messages());
        Position::findOrFail($this->id)->update([
            'name' => $this->name
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('jabatan.index');
    }
}
