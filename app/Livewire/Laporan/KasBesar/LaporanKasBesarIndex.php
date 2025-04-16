<?php

namespace App\Livewire\Laporan\KasBesar;

use App\Models\KasBesar;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class LaporanKasBesarIndex extends Component
{
    public $search = "";
    public $startDate;
    public $endDate;
    public $categoryYears;

    public function mount() {
        $this->startDate = now()->startOfYear()->toDateString();
        $this->endDate = now()->endOfYear()->toDateString();
        $this->categoryYears = range(date('Y') - 2, date('Y'));
    }

    public function render()
    {
        Gate::authorize('viewAny', KasBesar::class);
        return view('livewire.laporan.kas-besar.laporan-kas-besar-index', [
            'totalPemasukan' => $this->totalPemasukan(),
            'totalPengeluaran' => $this->totalPengeluaran(),
            'fetchData' => $this->fetchData(),
            'columnChartKasBesar' => $this->columnChartKasBesar(),
            'barChartKasBesar' => $this->barChartKasBesar()
        ]);
    }

    public function filterData()
    {
        // Jika salah satu tanggal kosong, tetap gunakan default
        $this->startDate = $this->startDate ?: now()->startOfYear()->toDateString();
        $this->endDate = $this->endDate ?: now()->endOfYear()->toDateString();
    }

    public function totalPemasukan() {
        return DB::table('kas_besars')
            ->join('list_kas_besars', 'kas_besars.id', '=', 'list_kas_besars.kas_besar_id')
            ->where('kas_besars.category', 'Pemasukan')
            ->whereBetween('list_kas_besars.created_at', [$this->startDate, $this->endDate])
            ->sum('list_kas_besars.total') ?? 0;
    }

    public function totalPengeluaran() {
        return DB::table('kas_besars')
            ->join('list_kas_besars', 'kas_besars.id', '=', 'list_kas_besars.kas_besar_id')
            ->where('kas_besars.category', 'Pengeluaran')
            ->whereBetween('list_kas_besars.created_at', [$this->startDate, $this->endDate])
            ->sum('list_kas_besars.total') ?? 0;
    }

    public function fetchData() {
        return KasBesar::latest()
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->paginate(20);
    }

    public function columnChartKasBesar() {
        $currentYear = Carbon::now()->year;

        $monthlyTotals = collect(DB::table('kas_besars')
            ->join('list_kas_besars', 'kas_besars.id', '=', 'list_kas_besars.kas_besar_id')
            ->select(
                DB::raw('MONTH(kas_besars.created_at) as month'),
                'kas_besars.category',
                DB::raw('SUM(list_kas_besars.total) as total')
            )
            ->whereYear('kas_besars.created_at', $currentYear)
            ->whereIn('kas_besars.category', ['Pemasukan', 'Pengeluaran'])
            ->groupBy(DB::raw('MONTH(kas_besars.created_at)'), 'kas_besars.category')
            ->orderBy(DB::raw('MONTH(kas_besars.created_at)'))
            ->get());

        $categories = ['Pemasukan', 'Pengeluaran'];

        return collect($categories)->map(function ($category) use ($monthlyTotals) {
            return [
                'name' => $category,
                'data' => collect(range(1, 12))->map(function ($month) use ($monthlyTotals, $category) {
                    $record = $monthlyTotals->where('category', $category)->where('month', $month)->first();
                    return $record ? $record->total : 0;
                })->toArray()
            ];
        })->toArray();
    }

    public function barChartKasBesar() {
        $startYear = now()->year - 2; // 3 tahun terakhir: 2023, 2024, 2025
        $endYear = now()->year;

        // Ambil data group by year dan category
        $yearlyTotals = DB::table('kas_besars')
            ->join('list_kas_besars', 'kas_besars.id', '=', 'list_kas_besars.kas_besar_id')
            ->select(
                DB::raw('YEAR(kas_besars.created_at) as year'),
                'kas_besars.category',
                DB::raw('SUM(list_kas_besars.total) as total')
            )
            ->whereBetween(DB::raw('YEAR(kas_besars.created_at)'), [$startYear, $endYear])
            ->whereIn('kas_besars.category', ['Pemasukan', 'Pengeluaran'])
            ->groupBy(DB::raw('YEAR(kas_besars.created_at)'), 'kas_besars.category')
            ->orderBy(DB::raw('YEAR(kas_besars.created_at)'))
            ->get();

        $categories = ['Pemasukan', 'Pengeluaran'];
        $years = range($startYear, $endYear); // [2023, 2024, 2025]

        return collect($categories)->map(function ($category) use ($yearlyTotals, $years) {
            return [
                'name' => $category,
                'data' => collect($years)->map(function ($year) use ($yearlyTotals, $category) {
                    $record = $yearlyTotals->where('category', $category)->where('year', $year)->first();
                    return $record ? $record->total : 0;
                })->toArray()
            ];
        })->toArray();
    }
}
