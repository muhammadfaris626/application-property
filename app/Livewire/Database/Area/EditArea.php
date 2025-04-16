<?php

namespace App\Livewire\Database\Area;

use App\Http\Requests\AreaRequest;
use App\Models\Area;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditArea extends Component
{
    public $id, $name, $address;
    public function render()
    {
        return view('livewire.database.area.edit-area');
    }

    public function mount($id) {
        $data = Area::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'name', 'address']));
    }

    public function update() {
        $request = new AreaRequest();
        $this->validate($request->rules(), $request->messages());
        Area::findOrFail($this->id)->update([
            'name' => $this->name,
            'address' => $this->address
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('area.index');
    }
}
