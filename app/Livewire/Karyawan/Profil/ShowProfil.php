<?php

namespace App\Livewire\Karyawan\Profil;

use App\Models\Structure;
use Livewire\Component;

class ShowProfil extends Component
{
    public $id, $show;

    public function mount($id) {
        $this->id = $id;
        $this->show = Structure::where('id', $id)->first();
    }

    public function render()
    {
        return view('livewire.karyawan.profil.show-profil');
    }
}
