<?php

namespace App\Livewire\Karyawan\Kinerja;

use App\Models\ProspectiveCustomer;
use App\Models\Structure;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowKinerja extends Component
{
    public $id, $employee_id, $data;
    public $startDate;
    public $endDate;

    public function mount($id) {
        $this->id = $id;
        $this->data = Structure::findOrFail($id);
        $this->employee_id = $this->data->employee_id;
        $this->startDate = now()->startOfYear()->toDateString();
        $this->endDate = now()->endOfYear()->toDateString();
    }
    public function render()
    {
        return view('livewire.karyawan.kinerja.show-kinerja', [
            'totalCalonUser' => $this->totalCalonUser(),
            'totalUser' => $this->totalUser(),
            'totalKartuKontrol' => $this->totalKartuKontrol(),
            'columnChartKinerja' => $this->columnChartKinerja()
        ]);
    }

    public function filterData()
    {
        // Jika salah satu tanggal kosong, tetap gunakan default
        $this->startDate = $this->startDate ?: now()->startOfYear()->toDateString();
        $this->endDate = $this->endDate ?: now()->endOfYear()->toDateString();
    }

    public function totalCalonUser() {
        return DB::table('prospective_customers')
            ->where('employee_id', $this->employee_id)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();
    }

    public function totalUser() {
        return DB::table('customers')
            ->where('employee_id', $this->employee_id)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();
    }

    public function totalKartuKontrol() {
        return DB::table('kartu_kontrols')
            ->where('employee_id', $this->employee_id)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();
    }

    public function columnChartKinerja() {
        // Ambil total per bulan dari prospective_customers
        $prospective = DB::table('prospective_customers')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->where('employee_id', $this->employee_id)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Ambil total per bulan dari customers
        $customers = DB::table('customers')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->where('employee_id', $this->employee_id)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Ambil total per bulan dari kartu_kontrols
        $kontrols = DB::table('kartu_kontrols')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->where('employee_id', $this->employee_id)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Generate data per bulan dari 1 sampai 12
        $monthlyTotals = function ($data) {
            return collect(range(1, 12))->map(function ($month) use ($data) {
                $record = $data->firstWhere('month', $month);
                return $record ? $record->total : 0;
            })->toArray();
        };

        // Hasil akhir untuk chart
        return [
            [
                'name' => 'Calon User',
                'data' => $monthlyTotals($prospective)
            ],
            [
                'name' => 'User',
                'data' => $monthlyTotals($customers)
            ],
            [
                'name' => 'Kartu Kontrol',
                'data' => $monthlyTotals($kontrols)
            ]
        ];
    }


}
