<?php

namespace App\Livewire\Database\Area;

use App\Models\Area;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexArea extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render() {
        Gate::authorize('viewAny', Area::class);
        $data = Area::latest()->paginate(19);
        if ($this->search != null) {
            $data = Area::where('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('address', 'LIKE', '%' . $this->search . '%')
                ->latest()->paginate(19);
        }
        return view('livewire.database.area.index-area', [
            'fetch' => $data
        ]);
    }
    public function destroy($id) {
        $data = Area::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
