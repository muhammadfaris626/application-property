<?php

namespace App\Livewire\Database\Supplier;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditSupplier extends Component
{
    public $id, $name;
    public function render()
    {
        return view('livewire.database.supplier.edit-supplier');
    }

    public function mount($id) {
        $data = Supplier::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'name']));
    }

    public function update() {
        $request = new SupplierRequest();
        $this->validate($request->rules(), $request->messages());
        Supplier::findOrFail($this->id)->update([
            'name' => $this->name
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('supplier.index');
    }
}
