<?php

namespace App\Livewire\Laporan\KasKecil;

use App\Models\Area;
use App\Models\KasKecil;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanKasKecilIndex extends Component
{
    use WithPagination;
    public $search = "";
    public $startDate;
    public $endDate;
    public $area_id;
    public $categoryYears;

    public function mount() {
        $this->startDate = now()->startOfYear()->toDateString();
        $this->endDate = now()->endOfYear()->toDateString();
        $this->area_id = 'all';
        $this->categoryYears = range(date('Y') - 2, date('Y'));
    }

    public function render()
    {
        Gate::authorize('viewAny', KasKecil::class);
        return view('livewire.laporan.kas-kecil.laporan-kas-kecil-index', [
            'totalPemasukan' => $this->totalPemasukan(),
            'totalPengeluaran' => $this->totalPengeluaran(),
            'fetchData' => $this->fetchData(),
            'columnChartKasKecil' => $this->columnChartKasKecil(),
            'barChartKasKecil' => $this->barChartKasKecil(),
            'areas' => Area::all()
        ]);
    }

    public function filterData()
    {
        // Jika salah satu tanggal kosong, tetap gunakan default
        $this->startDate = $this->startDate ?: now()->startOfYear()->toDateString();
        $this->endDate = $this->endDate ?: now()->endOfYear()->toDateString();
        $this->area_id = $this->area_id ?: 'all';
    }

    public function totalPemasukan() {
        return DB::table('kas_kecils')
            ->join('list_kas_kecils', 'kas_kecils.id', '=', 'list_kas_kecils.kas_kecil_id')
            ->when($this->area_id !== 'all', function ($query) {
                $query->where('kas_kecils.area_id', $this->area_id);
            })
            ->where('kas_kecils.category', 'Pemasukan')
            ->whereBetween('list_kas_kecils.created_at', [$this->startDate, $this->endDate])
            ->sum('list_kas_kecils.total') ?? 0;
    }

    public function totalPengeluaran() {
        return DB::table('kas_kecils')
            ->join('list_kas_kecils', 'kas_kecils.id', '=', 'list_kas_kecils.kas_kecil_id')
            ->when($this->area_id !== 'all', function ($query) {
                $query->where('kas_kecils.area_id', $this->area_id);
            })
            ->where('kas_kecils.category', 'Pengeluaran')
            ->whereBetween('list_kas_kecils.created_at', [$this->startDate, $this->endDate])
            ->sum('list_kas_kecils.total') ?? 0;
    }

    public function fetchData() {
        return KasKecil::latest()
            ->when($this->area_id !== 'all', function ($query) {
                $query->where('kas_kecils.area_id', $this->area_id);
            })
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->paginate(20);
    }

    public function columnChartKasKecil() {
        $currentYear = Carbon::now()->year;

        $monthlyTotals = collect(DB::table('kas_kecils')
            ->join('list_kas_kecils', 'kas_kecils.id', '=', 'list_kas_kecils.kas_kecil_id')
            ->select(
                DB::raw('MONTH(kas_kecils.created_at) as month'),
                'kas_kecils.category',
                DB::raw('SUM(list_kas_kecils.total) as total')
            )
            ->when($this->area_id !== 'all', function ($query) {
                $query->where('kas_kecils.area_id', $this->area_id);
            })
            ->whereYear('kas_kecils.created_at', $currentYear)
            ->whereIn('kas_kecils.category', ['Pemasukan', 'Pengeluaran'])
            ->groupBy(DB::raw('MONTH(kas_kecils.created_at)'), 'kas_kecils.category')
            ->orderBy(DB::raw('MONTH(kas_kecils.created_at)'))
            ->get());

        $categories = ['Pemasukan', 'Pengeluaran'];

        return collect($categories)->map(function ($category) use ($monthlyTotals) {
            return [
                'name' => $category,
                'data' => collect(range(1, 12))->map(function ($month) use ($monthlyTotals, $category) {
                    $record = $monthlyTotals->where('category', $category)->where('month', $month)->first();
                    return $record ? (int)$record->total : 0;
                })->toArray()
            ];
        })->toArray();
    }

    public function barChartKasKecil() {

        $startYear = now()->year - 2; // 3 tahun terakhir: 2023, 2024, 2025
        $endYear = now()->year;

        // Ambil data group by year dan category
        $yearlyTotals = DB::table('kas_kecils')
            ->join('list_kas_kecils', 'kas_kecils.id', '=', 'list_kas_kecils.kas_kecil_id')
            ->select(
                DB::raw('YEAR(kas_kecils.created_at) as year'),
                'kas_kecils.category',
                DB::raw('SUM(list_kas_kecils.total) as total')
            )
            ->when($this->area_id !== 'all', function ($query) {
                $query->where('kas_kecils.area_id', $this->area_id);
            })
            ->whereBetween(DB::raw('YEAR(kas_kecils.created_at)'), [$startYear, $endYear])
            ->whereIn('kas_kecils.category', ['Pemasukan', 'Pengeluaran'])
            ->groupBy(DB::raw('YEAR(kas_kecils.created_at)'), 'kas_kecils.category')
            ->orderBy(DB::raw('YEAR(kas_kecils.created_at)'))
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
