<?php

namespace App\Livewire\Database\JenisRumah;

use App\Models\TypeOfHouse;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexJenisRumah extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', TypeOfHouse::class);
        $data = TypeOfHouse::latest()->paginate(19);
        if ($this->search != null) {
            $data = TypeOfHouse::whereHas('area', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhere('code', 'LIKE', '%' . $this->search . '%')
            ->orWhere('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('price', 'LIKE', '%' . $this->search . '%')
            ->latest()->paginate(19);
        }
        return view('livewire.database.jenis-rumah.index-jenis-rumah', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = TypeOfHouse::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
