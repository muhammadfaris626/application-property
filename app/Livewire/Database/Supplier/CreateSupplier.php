<?php

namespace App\Livewire\Database\Supplier;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateSupplier extends Component
{
    public $name, $action;
    public function render()
    {
        Gate::authorize('create', Supplier::class);
        return view('livewire.database.supplier.create-supplier');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new SupplierRequest();
        $this->validate($request->rules(), $request->messages());
        Supplier::create([
            'name' => $this->name,
        ]);
        $this->reset(['name']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('supplier.index');
        }
    }
}
