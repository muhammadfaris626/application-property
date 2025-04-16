<?php

namespace App\Livewire\Pengaturan\Peran;

use App\Http\Requests\PeranRequest;
use App\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreatePeran extends Component
{
    public $name, $action;
    public function render()
    {
        Gate::authorize('create', Role::class);
        return view('livewire.pengaturan.peran.create-peran');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new PeranRequest();
        $this->validate($request->rules(), $request->messages());
        Role::create([
            'name' => $this->name
        ]);
        $this->dispatch('resetDropdown');
        $this->reset(['name']);
        if ($this->action === 'save_and_add') {
            $this->loadAvailableModels();
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('peran.index');
        }
    }
}
