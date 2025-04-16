<?php

namespace App\Livewire\Pengaturan\Peran;

use App\Http\Requests\PeranRequest;
use App\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class EditPeran extends Component
{
    public $id, $name;

    public function mount($id)
    {
        $this->id = $id;
        $data = Role::findOrFail($id);
        Gate::authorize('update', $data);
        $this->name = $data->name;
    }

    public function render()
    {
        return view('livewire.pengaturan.peran.edit-peran');
    }

    public function update()
    {
        $request = new PeranRequest();
        $this->validate($request->rules(), $request->messages());

        Role::findOrFail($this->id)->update([
            'name' => $this->name
        ]);

        session()->flash('success', 'Data berhasil diperbarui.');
        return to_route('peran.index');
    }
}
