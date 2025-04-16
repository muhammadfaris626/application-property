<?php

namespace App\Livewire\Karyawan\Absensi;

use App\Models\Absensi;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexAbsensi extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];

    public function render()
    {
        Gate::authorize('viewAny', Absensi::class);
        $data = Absensi::latest()->paginate(19);
        if ($this->search != null) {
            $data = Absensi::where('date', 'LIKE', '%' . $this->search . '%')
                ->orWhere('check_in', 'LIKE', '%' . $this->search . '%')
                ->orWhere('check_out', 'LIKE', '%' . $this->search . '%')
                ->orWhereHas('employee', function($query) {
                    $query->where('name', 'LIKE', '%' . $this->search . '%');
                })
                ->latest()->paginate(19);
        }
        return view('livewire.karyawan.absensi.index-absensi', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = Absensi::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
