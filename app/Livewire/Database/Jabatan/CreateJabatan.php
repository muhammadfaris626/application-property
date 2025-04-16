<?php

namespace App\Livewire\Database\Jabatan;

use App\Http\Requests\PositionRequest;
use App\Models\Position;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateJabatan extends Component
{
    public $name, $action;
    public function render()
    {
        Gate::authorize('create', Position::class);
        return view('livewire.database.jabatan.create-jabatan');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new PositionRequest();
        $this->validate($request->rules(), $request->messages());
        Position::create([
            'name' => $this->name,
        ]);
        $this->reset(['name']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('jabatan.index');
        }
    }
}
