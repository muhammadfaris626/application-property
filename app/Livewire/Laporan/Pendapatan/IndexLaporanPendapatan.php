<?php

namespace App\Livewire\Laporan\Pendapatan;

use App\Models\Pendapatan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class IndexLaporanPendapatan extends Component
{
    public $search = "";
    public $startDate;
    public $endDate;

    public function mount() {
        $this->startDate = now()->startOfYear()->toDateString();
        $this->endDate = now()->endOfYear()->toDateString();
    }

    public function render()
    {
        Gate::authorize('viewAny', Pendapatan::class);
        return view('livewire.laporan.pendapatan.index-laporan-pendapatan', [
            'totalPendapatan' => $this->totalPendapatan(),
            'columnChartPendapatan' => $this->columnChartPendapatan(),
            'fetchData' => $this->fetchData()
        ]);
    }

    public function filterData()
    {
        // Jika salah satu tanggal kosong, tetap gunakan default
        $this->startDate = $this->startDate ?: now()->startOfYear()->toDateString();
        $this->endDate = $this->endDate ?: now()->endOfYear()->toDateString();
    }

    public function totalPendapatan() {
        return DB::table('pendapatans')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->sum('total') ?? 0;
    }

    public function columnChartPendapatan() {
        $currentYear = Carbon::now()->year;
        $years = [$currentYear - 2, $currentYear - 1, $currentYear]; // Contoh: 2023, 2024, 2025

        $monthlyTotals = collect(DB::table('pendapatans')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total_pendapatan')
            )
            ->whereIn(DB::raw('YEAR(created_at)'), $years)
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at)'), 'asc')
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get());

        return collect($years)->map(function ($year) use ($monthlyTotals) {
            return [
                'name' => (string) $year,
                'data' => collect(range(1, 12))->map(function ($month) use ($monthlyTotals, $year) {
                    $total = $monthlyTotals->where('year', $year)->where('month', $month)->first();
                    return $total ? (float) $total->total_pendapatan : 0;
                })->toArray()
            ];
        })->toArray();
    }

    public function fetchData() {
        $data = Pendapatan::latest()
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->paginate(20);
        return $data;
    }
}
