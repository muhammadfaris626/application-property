<?php

namespace App\Livewire\Laporan\PengajuanInvoice;

use App\Models\PengajuanInvoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class LaporanPengajuanInvoiceIndex extends Component
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
        Gate::authorize('viewAny', PengajuanInvoice::class);
        return view('livewire.laporan.pengajuan-invoice.laporan-pengajuan-invoice-index', [
            'totalBiayaPengajuan' => $this->totalBiayaPengajuan(),
            'columnChartPengajuan' => $this->columnChartPengajuan(),
            'fetchData' => $this->fetchData()
        ]);
    }

    public function filterData()
    {
        // Jika salah satu tanggal kosong, tetap gunakan default
        $this->startDate = $this->startDate ?: now()->startOfYear()->toDateString();
        $this->endDate = $this->endDate ?: now()->endOfYear()->toDateString();
    }

    public function totalBiayaPengajuan() {
        return DB::table('pengajuan_invoices')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->sum('approved_price') ?? 0;
    }

    public function columnChartPengajuan() {
        $currentYear = Carbon::now()->year;
        $years = [$currentYear - 2, $currentYear - 1, $currentYear]; // 2023, 2024, 2025
        $monthlyTotals = collect(DB::table('pengajuan_invoices')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(approved_price) as price')
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
                    return $total ? $total->price : 0;
                })->toArray()
            ];
        })->toArray();
    }

    public function fetchData() {
        $data = PengajuanInvoice::latest()
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->paginate(20);
        return $data;
    }
}
