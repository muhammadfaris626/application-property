<?php

namespace App\Livewire\Database\JenisPemasukan;

use App\Models\TypeOfIncome;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class IndexJenisPemasukan extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', TypeOfIncome::class);
        $data = TypeOfIncome::latest()->paginate(19);
        if ($this->search != null) {
            $data = TypeOfIncome::where('name', 'LIKE', '%' . $this->search . '%')
                ->latest()->paginate(19);
        }
        return view('livewire.database.jenis-pemasukan.index-jenis-pemasukan', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = TypeOfIncome::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
