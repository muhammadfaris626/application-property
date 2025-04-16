<?php

namespace App\Livewire\Database\JenisPemasukan;

use App\Http\Requests\TypeOfIncomeRequest;
use App\Models\TypeOfIncome;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditJenisPemasukan extends Component
{
    public $id, $name;
    public function render()
    {
        return view('livewire.database.jenis-pemasukan.edit-jenis-pemasukan');
    }

    public function mount($id) {
        $data = TypeOfIncome::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'name']));
    }

    public function update() {
        $request = new TypeOfIncomeRequest();
        $this->validate($request->rules(), $request->messages());
        TypeOfIncome::findOrFail($this->id)->update([
            'name' => $this->name
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('jenis-pemasukan.index');
    }
}
