<?php

namespace App\Livewire\Pengaturan\Perizinan;

use App\Http\Requests\PerizinanRequest;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreatePerizinan extends Component
{
    public $name, $action;
    public function render()
    {
        Gate::authorize('create', Permission::class);
        return view('livewire.pengaturan.perizinan.create-perizinan');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new PerizinanRequest();
        $this->validate($request->rules(), $request->messages());
        Permission::create([
            'name' => $this->name
        ]);
        $this->reset(['name']);
        if ($this->action === 'save_and_add') {
            // $this->loadAvailableModels();
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('perizinan.index');
        }
    }
}
