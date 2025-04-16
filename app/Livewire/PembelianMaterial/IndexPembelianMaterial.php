<?php

namespace App\Livewire\PembelianMaterial;

use App\Models\PurchaseOfMaterial;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPembelianMaterial extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', PurchaseOfMaterial::class);
        $data = PurchaseOfMaterial::latest()->paginate(19);
        if ($this->search != null) {
            $data = PurchaseOfMaterial::whereHas('supplier', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhereHas('employee', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhere('invoice_number', 'LIKE', '%' . $this->search . '%')
            ->orWhere('date', 'LIKE', '%' . $this->search . '%')
            ->latest()->paginate(19);
        }
        return view('livewire.pembelian-material.index-pembelian-material', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = PurchaseOfMaterial::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
