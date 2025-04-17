<?php

namespace App\Livewire\Karyawan\Absensi;

use App\Models\Absensi;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexAbsensi extends Component
{
    use WithPagination;

    public $search, $startDate, $endDate;

    // Menetapkan default tanggal pada awal dan akhir tahun
    public function mount()
    {
        $this->startDate = now()->startOfYear()->toDateString();
        $this->endDate = now()->endOfYear()->toDateString();
    }

    // Reset halaman dan filter berdasarkan tanggal
    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    // Menambahkan filter berdasarkan tanggal
    public function filterData()
    {
        $this->startDate = $this->startDate ?: now()->startOfYear()->toDateString();
        $this->endDate = $this->endDate ?: now()->endOfYear()->toDateString();
    }

    // Menetapkan parameter yang perlu diupdate pada query string
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']],
        ['startDate' => ['except' => '']],
        ['endDate' => ['except' => '']]
    ];

    // Render halaman dengan data absensi
    public function render()
    {
        Gate::authorize('viewAny', Absensi::class);

        $data = Absensi::query();

        // Menambahkan filter berdasarkan pencarian
        if ($this->search) {
            $data->where(function($query) {
                $query->where('date', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('check_in', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('check_out', 'LIKE', '%' . $this->search . '%')
                    ->orWhereHas('employee', function($query) {
                        $query->where('name', 'LIKE', '%' . $this->search . '%');
                    });
            });
        }

        // Menambahkan filter berdasarkan tanggal
        $data->whereBetween('created_at', [$this->startDate, $this->endDate]);

        // Mendapatkan hasil data dengan paginasi
        $data = $data->latest()->paginate(19);

        return view('livewire.karyawan.absensi.index-absensi', [
            'fetch' => $data
        ]);
    }

    // Hapus data absensi
    public function destroy($id)
    {
        $data = Absensi::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
