<?php

namespace App\Livewire\Karyawan\Kinerja;

use App\Models\ProspectiveCustomer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowKinerja extends Component
{
    public $id, $employee_id;

    public function mount($id) {
        $this->id = $id;
        $data = ProspectiveCustomer::findOrFail($id);
        $this->employee_id = $data->employee_id;
    }
    public function render()
    {
        return view('livewire.karyawan.kinerja.show-kinerja', [
            'totalHarian' => $this->totalHarian(),
            'totalMingguan' => $this->totalMingguan(),
            'totalBulanan' => $this->totalBulanan(),
            'columnChartKinerja' => $this->columnChartKinerja()
        ]);
    }

    public function totalHarian() {
        return DB::table('prospective_customers')
            ->where('employee_id', $this->employee_id)
            ->whereDate('created_at', Carbon::today())
            ->count();
    }

    public function totalMingguan() {
        $startOfWeek = Carbon::now()->startOfWeek(); // Mulai dari Senin
        $endOfWeek = Carbon::now()->endOfWeek();     // Sampai Minggu

        return DB::table('prospective_customers')
            ->where('employee_id', $this->employee_id)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();
    }

    public function totalBulanan() {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return DB::table('prospective_customers')
            ->where('employee_id', $this->employee_id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();
    }

    public function columnChartKinerja() {
        $currentYear = Carbon::now()->year;
        $years = [$currentYear - 2, $currentYear - 1, $currentYear];

        $monthlyTotals = collect(DB::table('prospective_customers')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total_price')
            )
            ->where('employee_id', $this->employee_id)
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
}
