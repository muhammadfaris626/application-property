<?php

namespace App\Livewire\Pengeluaran\KasBesar;

use App\Models\KasBesar;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPengeluaranKasBesar extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', KasBesar::class);
        $data = KasBesar::where('category', 'Pengeluaran')->latest()->paginate(19);
        if ($this->search != null) {
            $data = KasBesar::where('category', 'Pengeluaran')
                ->when($this->search != null, function ($query) {
                    $query->where(function ($q) {
                        $q->where('date', 'LIKE', '%' . $this->search . '%')
                        ->orWhereHas('employee', function ($q2) {
                            $q2->where('name', 'LIKE', '%' . $this->search . '%');
                        });
                    });
                })
                ->latest()->paginate(19);
        }
        return view('livewire.pengeluaran.kas-besar.index-pengeluaran-kas-besar', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = KasBesar::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
