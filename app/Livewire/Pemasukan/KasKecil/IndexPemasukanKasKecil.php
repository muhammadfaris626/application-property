<?php

namespace App\Livewire\Pemasukan\KasKecil;

use App\Models\KasKecil;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPemasukanKasKecil extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', KasKecil::class);
        $data = KasKecil::where('category', 'Pemasukan')->latest()->paginate(19);
        if ($this->search != null) {
            $data = KasKecil::where('category', 'Pemasukan')
                ->when($this->search != null, function ($query) {
                    $query->where(function ($q) {
                        $q->where('date', 'LIKE', '%' . $this->search . '%')
                        ->orWhereHas('employee', function ($q2) {
                            $q2->where('name', 'LIKE', '%' . $this->search . '%');
                        })
                        ->orWhereHas('area', function ($q3) {
                            $q3->where('name', 'LIKE', '%' . $this->search . '%');
                        });
                    });
                })
                ->latest()->paginate(19);
        }
        return view('livewire.pemasukan.kas-kecil.index-pemasukan-kas-kecil', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = KasKecil::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
