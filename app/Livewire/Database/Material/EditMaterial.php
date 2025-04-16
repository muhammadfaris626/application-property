<?php

namespace App\Livewire\Database\Material;

use App\Http\Requests\MaterialRequest;
use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditMaterial extends Component
{
    public $id, $material_category_id, $name;
    public $search = "";
    public function render()
    {
        return view('livewire.database.material.edit-material', [
            'fetchData' => MaterialCategory::all()
        ]);
    }

    public function mount($id) {
        $data = Material::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'material_category_id', 'name']));
    }

    public function update() {
        $request = new MaterialRequest();
        $this->validate($request->rules(), $request->messages());
        Material::findOrFail($this->id)->update([
            'material_category_id' => $this->material_category_id,
            'name' => $this->name,
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('material.index');
    }
}
