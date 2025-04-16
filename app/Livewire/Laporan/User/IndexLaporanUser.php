<?php

namespace App\Livewire\Laporan\User;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class IndexLaporanUser extends Component
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
        Gate::authorize('viewAny', Customer::class);
        return view('livewire.laporan.user.index-laporan-user', [
            'totalUser' => $this->totalUser(),
            'totalKredit' => $this->totalKredit(),
            'totalCash' => $this->totalCash(),
            'columnChartPenjualanUser' => $this->columnChartPenjualanUser(),
            'barChartPenjualanUser' => $this->barChartPenjualanUser(),
            'fetchData' => $this->fetchData()
        ]);
    }

    public function filterData()
    {
        // Jika salah satu tanggal kosong, tetap gunakan default
        $this->startDate = $this->startDate ?: now()->startOfYear()->toDateString();
        $this->endDate = $this->endDate ?: now()->endOfYear()->toDateString();
    }

    public function totalUser() {
        return DB::table('customers')
            ->whereBetween('customers.created_at', [$this->startDate, $this->endDate])
            ->count();
    }

    public function totalKredit() {
        return DB::table('customers')
            ->where('customers.status_penjualan', 'LIKE', '%' . 'KREDIT' . '%')
            ->whereBetween('customers.created_at', [$this->startDate, $this->endDate])
            ->count();
    }

    public function totalCash() {
        return DB::table('customers')
            ->where('customers.status_penjualan', 'LIKE', '%' . 'CASH' . '%')
            ->whereBetween('customers.created_at', [$this->startDate, $this->endDate])
            ->count();
    }

    public function columnChartPenjualanUser() {
        $currentYear = now()->year;

        $monthlyTotals = collect(DB::table('customers')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw("
                    CASE
                        WHEN status_penjualan LIKE '%KREDIT%' THEN 'KREDIT'
                        ELSE status_penjualan
                    END as category
                "),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', $currentYear)
            ->whereIn('status_penjualan', ['KREDIT FLPP', 'KREDIT TAPERA', 'CASH']) // atau sesuaikan kalau ada lebih
            ->groupBy(DB::raw('MONTH(created_at)'), 'category')
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get());

        $categories = ['KREDIT', 'CASH'];

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

    public function barChartPenjualanUser() {
        $startYear = now()->year - 2; // Misal: 2023
        $endYear = now()->year;       // Misal: 2025

        // Ambil total record per kategori (KREDIT atau CASH) per tahun
        $yearlyTotals = DB::table('customers')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw("
                    CASE
                        WHEN status_penjualan LIKE '%KREDIT%' THEN 'KREDIT'
                        WHEN status_penjualan = 'CASH' THEN 'CASH'
                        ELSE 'LAINNYA'
                    END as category
                "),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween(DB::raw('YEAR(created_at)'), [$startYear, $endYear])
            ->where(function ($query) {
                $query->where('status_penjualan', 'CASH')
                    ->orWhere('status_penjualan', 'LIKE', '%KREDIT%');
            })
            ->groupBy(DB::raw('YEAR(created_at)'), 'category')
            ->orderBy(DB::raw('YEAR(created_at)'))
            ->get();

        $categories = ['KREDIT', 'CASH'];
        $years = range($startYear, $endYear);

        return collect($categories)->map(function ($category) use ($yearlyTotals, $years) {
            return [
                'name' => $category,
                'data' => collect($years)->map(function ($year) use ($yearlyTotals, $category) {
                    $record = $yearlyTotals->where('category', $category)->where('year', $year)->first();
                    return $record ? (int) $record->total : 0;
                })->toArray()
            ];
        })->toArray();
    }

    public function fetchData() {
        return Customer::latest()
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->paginate(20);
    }
}
