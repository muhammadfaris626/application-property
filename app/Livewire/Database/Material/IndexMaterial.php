<?php

namespace App\Livewire\Database\Material;

use App\Models\Material;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexMaterial extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', Material::class);
        $data = Material::latest()->paginate(19);
        if ($this->search != null) {
            $data = Material::whereHas('materialCategory', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhere('name', 'LIKE', '%' . $this->search . '%')
            ->latest()->paginate(19);
        }
        return view('livewire.database.material.index-material', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = Material::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
