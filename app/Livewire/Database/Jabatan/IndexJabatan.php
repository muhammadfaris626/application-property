<?php

namespace App\Livewire\Database\Jabatan;

use App\Models\Position;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexJabatan extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', Position::class);
        $data = Position::latest()->paginate(19);
        if ($this->search != null) {
            $data = Position::where('name', 'LIKE', '%' . $this->search . '%')
                ->latest()->paginate(19);
        }
        return view('livewire.database.jabatan.index-jabatan', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = Position::findOrFail($id);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
