<?php

namespace App\Livewire\Database\JenisPengeluaran;

use App\Models\TypeOfExpenditure;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexJenisPengeluaran extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', TypeOfExpenditure::class);
        $data = TypeOfExpenditure::latest()->paginate(19);
        if ($this->search != null) {
            $data = TypeOfExpenditure::where('name', 'LIKE', '%' . $this->search . '%')
                ->latest()->paginate(19);
        }
        return view('livewire.database.jenis-pengeluaran.index-jenis-pengeluaran', [
            'fetch' => $data
        ]);
    }
    public function destroy($id) {
        $data = TypeOfExpenditure::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
