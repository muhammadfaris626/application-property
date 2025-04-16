<?php

namespace App\Livewire\Pengaturan\Akun;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateAkun extends Component
{
    public $name, $email, $password, $role_id, $action;
    public $fetchPeran;

    public function mount() {
        $this->fetchPeran = Role::all();
    }

    public function render()
    {
        Gate::authorize('create', User::class);
        return view('livewire.pengaturan.akun.create-akun');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new UserRequest();
        $this->validate($request->rules(), $request->messages());
        $create = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);
        $role = Role::find($this->role_id);
        $create->syncRoles($role->name);
        $this->dispatch('resetDropdown');
        $this->reset(['name', 'email', 'password', 'role_id']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('akun.index');
        }
    }
}
