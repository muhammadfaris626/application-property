<?php

namespace App\Livewire\Pemasukan\Pendapatan;

use App\Models\Pendapatan;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPendapatan extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];

    public function render()
    {
        Gate::authorize('viewAny', Pendapatan::class);
        $data = Pendapatan::latest()->paginate(19);
        if ($this->search != null) {
            $data = Pendapatan::where('tanggal', 'LIKE', '%' . $this->search . '%')
                ->orWhereHas('typeOfIncome', function($query) {
                    $query->where('name', 'LIKE', '%' . $this->search . '%');
                })
                ->orWHereHas('customer', function($query) {
                    $query->whereHas('prospectiveCustomer', function($query1) {
                        $query1->where('identification_number', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('name', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('address', 'LIKE', '%' . $this->search . '%');
                    });
                })
                ->orWhere('keterangan', 'LIKE', '%' . $this->search . '%')
                ->orWhere('total', 'LIKE', '%' . $this->search . '%')
                ->latest()->paginate(19);
        }
        return view('livewire.pemasukan.pendapatan.index-pendapatan', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = Pendapatan::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
