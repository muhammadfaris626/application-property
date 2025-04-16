<?php

namespace App\Livewire\Database\Supplier;

use App\Models\Supplier;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexSupplier extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', Supplier::class);
        $data = Supplier::latest()->paginate(19);
        if ($this->search != null) {
            $data = Supplier::where('name', 'LIKE', '%' . $this->search . '%')
                ->latest()->paginate(19);
        }
        return view('livewire.database.supplier.index-supplier', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = Supplier::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
