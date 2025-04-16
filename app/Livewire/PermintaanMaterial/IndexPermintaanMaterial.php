<?php

namespace App\Livewire\PermintaanMaterial;

use App\Models\PermintaanMaterial;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPermintaanMaterial extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];

    public function render()
    {
        Gate::authorize('viewAny', PermintaanMaterial::class);
        $data = PermintaanMaterial::with('approvalHistories')->latest()->paginate(19);
        if ($this->search != null) {
            $data = PermintaanMaterial::where('date', 'LIKE', '%' . $this->search . '%')
                ->orWhere('ro_number', 'LIKE', '%' . $this->search . '%')
                ->orWhereHas('employee', function($query) {
                    $query->where('name', 'LIKE', '%' . $this->search . '%');
                })
                ->latest()->paginate(19);
        }
        return view('livewire.permintaan-material.index-permintaan-material', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = PermintaanMaterial::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
