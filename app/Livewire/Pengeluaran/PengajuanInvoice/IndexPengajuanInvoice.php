<?php

namespace App\Livewire\Pengeluaran\PengajuanInvoice;

use App\Models\PengajuanInvoice;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPengajuanInvoice extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];

    public function render()
    {
        Gate::authorize('viewAny', PengajuanInvoice::class);
        $data = PengajuanInvoice::latest()->paginate(19);
        if ($this->search != null) {
            $data = PengajuanInvoice::where('date', 'LIKE', '%' . $this->search . '%')
                ->orWhere('price', 'LIKE', '%' . $this->search . '%')
                ->orWhere('desc', 'LIKE', '%' . $this->search . '%')
                ->orWhereHas('employee', function($query) {
                    $query->where('name', 'LIKE', '%' . $this->search . '%');
                })
                ->latest()->paginate(19);
        }
        return view('livewire.pengeluaran.pengajuan-invoice.index-pengajuan-invoice', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = PengajuanInvoice::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
