<?php

namespace App\Livewire\Laporan\PembelianMaterial;

use App\Models\PurchaseOfMaterial;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanPembelianMaterialIndex extends Component
{
    use WithPagination;
    public $search = "";
    public $startDate;
    public $endDate;

    public function mount() {
        $this->startDate = now()->startOfYear()->toDateString();
        $this->endDate = now()->endOfYear()->toDateString();
    }

    public function render()
    {
        Gate::authorize('viewAny', PurchaseOfMaterial::class);
        return view('livewire.laporan.pembelian-material.laporan-pembelian-material-index', [
            'totalPembelian' => $this->totalPembelian(),
            'jumlahMaterial' => $this->jumlahMaterial(),
            'jumlahFaktur' => $this->jumlahFaktur(),
            'columnChartPembelian' => $this->columnChartPembelian(),
            'fetchData' => $this->fetchData()
        ]);
    }

    public function filterData()
    {
        // Jika salah satu tanggal kosong, tetap gunakan default
        $this->startDate = $this->startDate ?: now()->startOfYear()->toDateString();
        $this->endDate = $this->endDate ?: now()->endOfYear()->toDateString();
    }

    public function totalPembelian() {
        return DB::table('list_purchase_of_materials')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->sum('total_price') ?? 0;
    }

    public function jumlahMaterial() {
        return DB::table('list_purchase_of_materials')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->sum('quantity') ?? 0;
    }

    public function jumlahFaktur() {
        return DB::table('purchase_of_materials')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count() ?? 0;
    }

    public function columnChartPembelian() {
        $currentYear = Carbon::now()->year;
        $years = [$currentYear - 2, $currentYear - 1, $currentYear]; // 2023, 2024, 2025

        $monthlyTotals = collect(DB::table('list_purchase_of_materials')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total_price')
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
                    return $total ? $total->total_price : 0;
                })->toArray()
            ];
        })->toArray();
    }

    public function fetchData() {
        $data = PurchaseOfMaterial::latest()
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->paginate(20);
        return $data;
    }
}
