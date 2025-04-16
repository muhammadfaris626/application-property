<?php

namespace App\Livewire\Kehadiran;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class IndexKehadiran extends Component
{
    use WithPagination;

    public $kehadiran, $search;
    public $startDate;
    public $endDate;

    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']],
        ['startDate' => ['except' => '']],
        ['endDate' => ['except' => '']],
    ];

    public function mount()
    {
        $this->startDate = $this->startDate ?? now()->startOfYear()->toDateString();
        $this->endDate = $this->endDate ?? now()->endOfYear()->toDateString();

        $today = Carbon::today()->toDateString();
        $this->kehadiran = Absensi::where('employee_id', Auth::user()->employee_id)
            ->where('date', $today)
            ->first();
    }

    public function render()
    {
        $query = Absensi::where('employee_id', Auth::user()->employee_id);

        // Filter berdasarkan range tanggal
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date', [$this->startDate, $this->endDate]);
        }

        // Filter pencarian jika diisi
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('date', 'LIKE', '%' . $this->search . '%');
            });
        }

        $data = $query->latest()->paginate(19);

        return view('livewire.kehadiran.index-kehadiran', [
            'fetch' => $data,
        ]);
    }

    public function absenMasuk()
    {
        Absensi::create([
            'employee_id' => Auth::user()->employee_id,
            'date' => Carbon::today()->toDateString(),
            'check_in' => Carbon::now()->toTimeString(),
        ]);

        session()->flash('success', 'Berhasil absen masuk.');
        return to_route('kehadiran');
    }

    public function absenKeluar()
    {
        $hariIni = Carbon::today()->toDateString();
        $absen = Absensi::where('date', $hariIni)
            ->where('employee_id', Auth::user()->employee_id)
            ->first();

        $absen?->update([
            'check_out' => Carbon::now()->toTimeString(),
        ]);

        session()->flash('success', 'Berhasil absen keluar.');
        return to_route('kehadiran');
    }

    public function filterData()
    {
        $this->startDate = $this->startDate ?: now()->startOfYear()->toDateString();
        $this->endDate = $this->endDate ?: now()->endOfYear()->toDateString();
        $this->resetPage();
    }
}
