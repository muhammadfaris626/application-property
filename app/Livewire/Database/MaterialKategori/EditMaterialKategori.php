<?php

namespace App\Livewire\Database\MaterialKategori;

use App\Http\Requests\MaterialCategoryRequest;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditMaterialKategori extends Component
{
    public $id, $code, $name;
    public function render()
    {
        return view('livewire.database.material-kategori.edit-material-kategori');
    }

    public function mount($id) {
        $data = MaterialCategory::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'code', 'name']));
    }

    public function update() {
        $request = new MaterialCategoryRequest();
        $this->validate($request->rules(), $request->messages());
        MaterialCategory::findOrFail($this->id)->update([
            'code' => $this->code,
            'name' => $this->name
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('material-kategori.index');
    }
}
