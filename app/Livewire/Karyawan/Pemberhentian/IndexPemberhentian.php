<?php

namespace App\Livewire\Karyawan\Pemberhentian;

use App\Models\Employee;
use App\Models\Termination;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPemberhentian extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', Termination::class);
        $data = Termination::latest()->paginate(19);
        if ($this->search != null) {
            $data = Termination::where('date', 'LIKE', '%' . $this->search . '%')
                ->orWhereHas('employee', function($query) {
                    $query->where('name', 'LIKE', '%' . $this->search . '%');
                })
                ->latest()->paginate(19);
        }
        return view('livewire.karyawan.pemberhentian.index-pemberhentian', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = Termination::findOrFail($id);
        Gate::authorize('delete', $data);
        User::where('employee_id', $data->employee_id)->update([
            'active' => 1
        ]);
        Employee::where('id', $data->employee_id)->update([
            'active' => 1
        ]);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
