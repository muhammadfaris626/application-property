<?php

namespace App\Livewire\Pengeluaran\PengajuanInvoice;

use App\Models\PengajuanInvoice;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPengajuanInvoice extends Component
{
    use WithPagination;

    public $search, $filterStatus;

    public function mount()
    {
        $this->filterStatus = 'all';
    }

    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']],
        ['filterStatus' => ['except' => 'all']],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        Gate::authorize('viewAny', PengajuanInvoice::class);

        $data = PengajuanInvoice::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('date', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('price', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('desc', 'LIKE', '%' . $this->search . '%')
                        ->orWhereHas('employee', function ($query) {
                            $query->where('name', 'LIKE', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->filterStatus !== 'all', function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->latest()
            ->paginate(19);

        return view('livewire.pengeluaran.pengajuan-invoice.index-pengajuan-invoice', [
            'fetch' => $data
        ]);
    }

    public function destroy($id)
    {
        $data = PengajuanInvoice::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
