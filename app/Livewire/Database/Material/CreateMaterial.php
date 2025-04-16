<?php

namespace App\Livewire\Database\Material;

use App\Http\Requests\MaterialRequest;
use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateMaterial extends Component
{
    public $material_category_id, $name, $action;
    public $search = "";
    public function render()
    {
        Gate::authorize('create', Material::class);
        return view('livewire.database.material.create-material', [
            'fetchData' => MaterialCategory::all()
        ]);
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new MaterialRequest();
        $this->validate($request->rules(), $request->messages());
        Material::create([
            'material_category_id' => $this->material_category_id,
            'name' => $this->name,
        ]);
        $this->dispatch('resetDropdown');
        $this->reset(['material_category_id', 'name']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('material.index');
        }
    }
}
