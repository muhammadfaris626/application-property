<?php

namespace App\Livewire\Penjualan\KartuKontrol;

use App\Models\KartuKontrol;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexKartuKontrol extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', KartuKontrol::class);
        $data = KartuKontrol::latest()->paginate(19);
        if ($this->search != null) {
            $data = KartuKontrol::where('tanggal', 'LIKE', '%' . $this->search . '%')
                ->orWhereHas('customer', function($query) {
                    $query->whereHas('prospectiveCustomer', function($query1) {
                        $query1->where('name', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('identification_number', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('address', 'LIKE', '%' . $this->search . '%');
                    });
                })
                ->latest()->paginate(19);
        }
        return view('livewire.penjualan.kartu-kontrol.index-kartu-kontrol', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = KartuKontrol::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
