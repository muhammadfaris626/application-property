<?php

namespace App\Livewire\Database\JenisRumah;

use App\Http\Requests\TypeOfHouseRequest;
use App\Models\Area;
use App\Models\TypeOfHouse;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditJenisRumah extends Component
{
    public $id, $area_id, $code, $name, $price;
    public $search = "";
    public function render()
    {
        return view('livewire.database.jenis-rumah.edit-jenis-rumah', [
            'fetchData' => Area::all()
        ]);
    }

    public function mount($id) {
        $data = TypeOfHouse::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'area_id', 'code', 'name', 'price']));
    }

    public function update() {
        $request = new TypeOfHouseRequest();
        $this->validate($request->rules(), $request->messages());
        $cleanPrice = str_replace('.', '', $this->price);
        TypeOfHouse::findOrFail($this->id)->update([
            'area_id' => $this->area_id,
            'code' => $this->code,
            'name' => $this->name,
            'price' => $cleanPrice
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('jenis-rumah.index');
    }
}
