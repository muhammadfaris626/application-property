<?php

namespace App\Livewire\Struktur;

use App\Models\Employee;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexStruktur extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', Structure::class);
        $data = Structure::latest()->paginate(19);
        if ($this->search != null) {
            $data = Structure::whereHas('employee', function($query) {
                $query->where('identification_number', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhereHas('position', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhereHas('area', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhere('employee_number', 'LIKE', '%' . $this->search . '%')
            ->latest()->paginate(19);
        }
        return view('livewire.struktur.index-struktur', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = Structure::findOrFail($id);
        Gate::authorize('delete', $data);
        User::where('employee_id', $data->employee_id)->update([
            'area_id' => null,
            'active' => 0
        ]);
        Employee::where('id', $data->employee_id)->update([
            'active' => 0
        ]);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
