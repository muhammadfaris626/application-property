<?php

namespace App\Livewire\Laporan\DataJaminanUser;

use App\Models\KartuKontrol;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class LaporanDataJaminanUserIndex extends Component
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
        Gate::authorize('viewAny', KartuKontrol::class);
        return view('livewire.laporan.data-jaminan-user.laporan-data-jaminan-user-index', [
            'totalDajamUser' => $this->totalDajamUser(),
            'totalTerverifikasi' => $this->totalTerverifikasi(),
            'totalBelumTerverifikasi' => $this->totalBelumTerverifikasi(),
            'columnChartDajam' => $this->columnChartDajam(),
            'columnChartDajamYears' => $this->columnChartDajamYears(),
            'fetchData' => $this->fetchData()
        ]);
    }

    public function filterData()
    {
        // Jika salah satu tanggal kosong, tetap gunakan default
        $this->startDate = $this->startDate ?: now()->startOfYear()->toDateString();
        $this->endDate = $this->endDate ?: now()->endOfYear()->toDateString();
    }

    public function totalDajamUser() {
        return DB::table('kartu_kontrols')
            ->whereBetween('kartu_kontrols.created_at', [$this->startDate, $this->endDate])
            ->count();
    }

    public function totalTerverifikasi() {
        return DB::table('kartu_kontrols')
            ->whereBetween('kartu_kontrols.created_at', [$this->startDate, $this->endDate])
            ->where('sbum', 1)
            ->where('dp', 1)
            ->where('imb', 1)
            ->where('sertifikat', 1)
            ->where('jkk', 1)
            ->where('listrik', 1)
            ->where('bestek', 1)
            ->count();
    }

    public function totalBelumTerverifikasi() {
        return DB::table('kartu_kontrols')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->where(function ($query) {
                $query->whereNull('sbum')->orWhere('sbum', '!=', 1)
                    ->orWhereNull('dp')->orWhere('dp', '!=', 1)
                    ->orWhereNull('imb')->orWhere('imb', '!=', 1)
                    ->orWhereNull('sertifikat')->orWhere('sertifikat', '!=', 1)
                    ->orWhereNull('jkk')->orWhere('jkk', '!=', 1)
                    ->orWhereNull('listrik')->orWhere('listrik', '!=', 1)
                    ->orWhereNull('bestek')->orWhere('bestek', '!=', 1);
            })
            ->count();
    }

    public function columnChartDajam() {
        $currentYear = Carbon::now()->year;

        $monthlyTotals = collect(DB::table('kartu_kontrols')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', $currentYear)
            ->whereRaw('COALESCE(sbum, 0) = 1')
            ->whereRaw('COALESCE(dp, 0) = 1')
            ->whereRaw('COALESCE(imb, 0) = 1')
            ->whereRaw('COALESCE(sertifikat, 0) = 1')
            ->whereRaw('COALESCE(jkk, 0) = 1')
            ->whereRaw('COALESCE(listrik, 0) = 1')
            ->whereRaw('COALESCE(bestek, 0) = 1')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get()
            ->keyBy('month'));

        return [[
            'name' => 'Sudah Terverifikasi',
            'data' => collect(range(1, 12))->map(function ($month) use ($monthlyTotals) {
                return $monthlyTotals[$month]->total ?? 0;
            })->toArray(),
        ]];
    }

    public function columnChartDajamYears() {
        $currentYear = Carbon::now()->year;
        $years = [$currentYear - 2, $currentYear - 1, $currentYear]; // 3 tahun terakhir

        $monthlyTotals = collect(DB::table('kartu_kontrols')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereIn(DB::raw('YEAR(created_at)'), $years)
            ->whereRaw('COALESCE(sbum, 0) = 1')
            ->whereRaw('COALESCE(dp, 0) = 1')
            ->whereRaw('COALESCE(imb, 0) = 1')
            ->whereRaw('COALESCE(sertifikat, 0) = 1')
            ->whereRaw('COALESCE(jkk, 0) = 1')
            ->whereRaw('COALESCE(listrik, 0) = 1')
            ->whereRaw('COALESCE(bestek, 0) = 1')
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at)'), 'asc')
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get());

        return collect($years)->map(function ($year) use ($monthlyTotals) {
            return [
                'name' => (string) $year,
                'data' => collect(range(1, 12))->map(function ($month) use ($monthlyTotals, $year) {
                    $record = $monthlyTotals->where('year', $year)->where('month', $month)->first();
                    return $record ? $record->total : 0;
                })->toArray()
            ];
        })->toArray();
    }

    public function fetchData() {
        $data = KartuKontrol::latest()
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->paginate(20);
        return $data;
    }
}
