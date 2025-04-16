<?php

namespace App\Livewire\Karyawan\Profil;

use App\Models\Structure;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexProfil extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];

    public function render()
    {
        Gate::authorize('viewAny', Structure::class);
        $data = Structure::latest()->paginate(19);
        if ($this->search != null) {
            $data = Structure::whereHas('employee', function($query) {
                $query->where('identification_number', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhereHas('position', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhereHas('area', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhere('employee_number', 'LIKE', '%' . $this->search . '%')
            ->latest()->paginate(19);
        }
        return view('livewire.karyawan.profil.index-profil', [
            'fetch' => $data
        ]);
    }
}
