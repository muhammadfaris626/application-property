<?php

namespace App\Livewire\Database\Karyawan;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexKaryawan extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', Employee::class);
        $data = Employee::latest()->paginate(19);
        if ($this->search != null) {
            $data = Employee::where('identification_number', 'LIKE', '%' . $this->search . '%')
                ->orWhere('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('address', 'LIKE', '%' . $this->search . '%')
                ->orWhere('place_of_birth', 'LIKE', '%' . $this->search . '%')
                ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                ->latest()->paginate(19);
        }
        return view('livewire.database.karyawan.index-karyawan', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = Employee::findOrFail($id);
        Gate::authorize('delete', $data);
        User::where('employee_id', $id)->first()->delete();
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
