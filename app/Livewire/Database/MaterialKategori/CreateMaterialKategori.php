<?php

namespace App\Livewire\Database\MaterialKategori;

use App\Http\Requests\MaterialCategoryRequest;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateMaterialKategori extends Component
{
    public $code = 'KM-XXXXX', $name, $action;
    public function render()
    {
        Gate::authorize('create', MaterialCategory::class);
        return view('livewire.database.material-kategori.create-material-kategori');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new MaterialCategoryRequest();
        $this->validate($request->rules(), $request->messages());
        $formatCode = 'KM-' . str_pad(MaterialCategory::count() + 1, 5, '0', STR_PAD_LEFT);
        MaterialCategory::create([
            'code' => $formatCode,
            'name' => $this->name,
        ]);
        $this->reset(['code', 'name']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('material-kategori.index');
        }
    }
}
