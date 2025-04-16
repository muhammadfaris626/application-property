<?php

namespace App\Livewire\Database\JenisRumah;

use App\Http\Requests\TypeOfHouseRequest;
use App\Models\Area;
use App\Models\TypeOfHouse;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateJenisRumah extends Component
{
    public $area_id, $code = 'TR-XXX', $name, $price, $action;
    public $search = "";
    public function render()
    {
        Gate::authorize('create', TypeOfHouse::class);
        return view('livewire.database.jenis-rumah.create-jenis-rumah', [
            'fetchData' => Area::all()
        ]);
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new TypeOfHouseRequest();
        $this->validate($request->rules(), $request->messages());
        $formatCode = 'TR-' . str_pad(TypeOfHouse::count() + 1, 3, '0', STR_PAD_LEFT);
        $cleanPrice = str_replace('.', '', $this->price);
        TypeOfHouse::create([
            'area_id' => $this->area_id,
            'code' => $formatCode,
            'name' => $this->name,
            'price' => $cleanPrice,
        ]);
        $this->reset(['area_id', 'code', 'name', 'price']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('jenis-rumah.index');
        }
    }
}
