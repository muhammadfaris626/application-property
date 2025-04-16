<?php

namespace App\Livewire\Database\Area;

use App\Http\Requests\AreaRequest;
use App\Models\Area;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateArea extends Component
{
    public $name, $address, $action;
    public function render()
    {
        Gate::authorize('create', Area::class);
        return view('livewire.database.area.create-area');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new AreaRequest();
        $this->validate($request->rules(), $request->messages());
        Area::create([
            'name' => $this->name,
            'address' => $this->address,
        ]);
        $this->reset(['name', 'address']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('area.index');
        }
    }
}
