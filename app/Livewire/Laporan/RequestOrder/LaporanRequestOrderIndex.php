<?php

namespace App\Livewire\Laporan\RequestOrder;

use App\Models\Area;
use App\Models\ListPermintaanMaterial;
use App\Models\MaterialCategory;
use App\Models\PermintaanMaterial;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanRequestOrderIndex extends Component
{
    use WithPagination;
    public $search = "";
    public $startDate;
    public $endDate;
    public $area_id;
    public $categoryYears;
    public $fetchArea;

    public function mount() {
        $this->startDate = now()->startOfYear()->toDateString();
        $this->endDate = now()->endOfYear()->toDateString();
        $this->area_id = 'all';
        $this->categoryYears = range(date('Y') - 2, date('Y'));
        $this->fetchArea = Area::all();
    }

    public function render()
    {
        Gate::authorize('viewAny', PermintaanMaterial::class);
        return view('livewire.laporan.request-order.laporan-request-order-index', [
            'areas' => Area::all(),
            'totalPermintaan' => $this->totalPermintaan(),
            'columnChartPermintaan' => $this->columnChartPermintaan(),
            'fetchData' => $this->fetchData()
        ]);
    }

    public function filterData()
    {
        // Jika salah satu tanggal kosong, tetap gunakan default
        $this->startDate = $this->startDate ?: now()->startOfYear()->toDateString();
        $this->endDate = $this->endDate ?: now()->endOfYear()->toDateString();
        $this->area_id = $this->area_id ?: 'all';
    }

    public function totalPermintaan() {
        return DB::table('permintaan_materials')
            ->when($this->area_id !== 'all', function ($query) {
                // Filter berdasarkan area_id dari permintaanMaterials
                $query->where('area_id', $this->area_id);
            })
            ->whereBetween('permintaan_materials.created_at', [$this->startDate, $this->endDate])

            ->count();
    }

    public function columnChartPermintaan() {
        $currentYear = Carbon::now()->year;
        $years = [$currentYear - 2, $currentYear - 1, $currentYear]; // 2023, 2024, 2025

        $monthlyTotals = collect(DB::table('permintaan_materials')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total_count')
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
                    return $total ? $total->total_count : 0;
                })->toArray()
            ];
        })->toArray();
    }

    public function fetchData() {
        $data = ListPermintaanMaterial::select(
                'material_categories.id',
                'material_categories.name as nama',
                DB::raw('SUM(list_permintaan_materials.approved_quantity) as jumlah_material'),
                DB::raw('COUNT(DISTINCT list_permintaan_materials.permintaan_material_id) as jumlah_pengajuan')
            )
            ->join('materials', 'list_permintaan_materials.material_id', '=', 'materials.id')
            ->join('material_categories', 'materials.material_category_id', '=', 'material_categories.id')
            ->join('permintaan_materials', 'list_permintaan_materials.permintaan_material_id', '=', 'permintaan_materials.id') // Join tabel permintaanMaterials
            ->whereBetween('list_permintaan_materials.created_at', [$this->startDate, $this->endDate])
            ->when($this->area_id !== 'all', function ($query) {
                // Filter berdasarkan area_id dari permintaanMaterials
                $query->where('permintaan_materials.area_id', $this->area_id);
            })
            ->groupBy('material_categories.id', 'material_categories.name')
            ->paginate(20);
        return $data;
    }
}
