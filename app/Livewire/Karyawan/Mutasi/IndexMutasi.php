<?php

namespace App\Livewire\Karyawan\Mutasi;

use App\Models\Mutation;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexMutasi extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', Mutation::class);
        $data = Mutation::paginate(19);
        if ($this->search != null) {
            $data = Mutation::whereHas('employee', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhereHas('fromArea', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWherehas('toArea', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhere('date', 'LIKE', '%' . $this->search . '%')
            ->paginate(19);
        }
        return view('livewire.karyawan.mutasi.index-mutasi', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = Mutation::findOrFail($id);
        Gate::authorize('delete', $data);
        Structure::where('employee_id', $data->employee_id)->update([
            'area_id' => $data->from_area_id
        ]);

        User::where('employee_id', $data->employee_id)->update([
            'area_id' => $data->from_area_id
        ]);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
