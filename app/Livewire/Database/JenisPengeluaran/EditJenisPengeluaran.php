<?php

namespace App\Livewire\Database\JenisPengeluaran;

use App\Http\Requests\TypeOfExpenditureRequest;
use App\Models\TypeOfExpenditure;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditJenisPengeluaran extends Component
{
    public $id, $name;
    public function render()
    {
        return view('livewire.database.jenis-pengeluaran.edit-jenis-pengeluaran');
    }

    public function mount($id) {
        $data = TypeOfExpenditure::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'name']));
    }

    public function update() {
        $request = new TypeOfExpenditureRequest();
        $this->validate($request->rules(), $request->messages());
        TypeOfExpenditure::findOrFail($this->id)->update([
            'name' => $this->name
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('jenis-pengeluaran.index');
    }
}
