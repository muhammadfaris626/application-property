<?php

namespace App\Livewire\Pengaturan\Akun;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EditAkun extends Component
{
    public $id, $name, $email, $password, $role_id;
    public $fetchPeran;
    public function render()
    {
        return view('livewire.pengaturan.akun.edit-akun');
    }

    public function mount($id) {
        $data = User::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'name', 'email', 'password']));
        $this->role_id = $data->roles->first()?->id ?? null;
        $this->fetchPeran = Role::all();
    }

    public function update() {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'role_id' => 'required|exists:roles,id',
        ], [
            'name.required' => 'Kolom nama wajib diisi.',
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Harap gunakan format email yang benar.',
            'email.unique' => 'Email ini sudah terdaftar, gunakan email lain.',
            'role_id.required' => 'Kolom peran wajib diisi.'
        ]);
        $user = User::findOrFail($this->id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password === true ? Hash::make('12345678') : $user->password
        ]);
        $role = Role::find($this->role_id);
        $user->syncRoles($role->name);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('akun.index');
    }
}
