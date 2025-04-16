<?php

namespace App\Livewire\Database\MaterialKategori;

use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexMaterialKategori extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', MaterialCategory::class);
        $data = MaterialCategory::latest()->paginate(19);
        if ($this->search != null) {
            $data = MaterialCategory::where('code', 'LIKE', '%' . $this->search . '%')
                ->orWhere('name', 'LIKE', '%' . $this->search . '%')
                ->latest()->paginate(19);
        }
        return view('livewire.database.material-kategori.index-material-kategori', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = MaterialCategory::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
