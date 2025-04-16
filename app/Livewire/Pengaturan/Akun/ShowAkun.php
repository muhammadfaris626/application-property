<?php

namespace App\Livewire\Pengaturan\Akun;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowAkun extends Component
{
    public $id, $show;
    public function render()
    {
        return view('livewire.pengaturan.akun.show-akun');
    }

    public function mount($id) {
        $this->id = $id;

        $user = User::with('roles')->findOrFail($id);
        Gate::authorize('view', $user);

        $fieldNames = [
            'name' => 'Nama',
            'email' => 'Email',
            'roles' => 'Peran'
        ];

        $roles = $user->roles->pluck('name')->toArray(); // Ambil nama rolenya

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $roles
        ];

        $filteredData = array_intersect_key($data, $fieldNames);

        $this->show = array_map(function ($key, $value) use ($fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => is_array($value) ? implode(', ', $value) : ($value ?? '-')
            ];
        }, array_keys($filteredData), $filteredData);
    }

}
