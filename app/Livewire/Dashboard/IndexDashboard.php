<?php

namespace App\Livewire\Dashboard;

use App\Models\Area;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IndexDashboard extends Component
{
    public $search = "";
    public $startDate;
    public $endDate;
    public $area_id;
    public $fetchArea;

    public function mount() {
        $this->startDate = now()->startOfYear()->toDateString();
        $this->endDate = now()->endOfYear()->toDateString();
        $this->area_id = 'all';
        $this->fetchArea = Area::all();
    }

    public function render()
    {
        return view('livewire.dashboard.index-dashboard', [
            'totalOmzet' => $this->totalOmzet(),
            'unitTerjual' => $this->unitTerjual(),
            'totalKaryawan' => $this->totalKaryawan(),
            'totalCalonUser' => $this->totalCalonUser(),
            'totalUserSpr' => $this->totalUserSpr(),
            'totalUserSp3k' => $this->totalUserSp3k(),
            'totalUserAkad' => $this->totalUserAkad(),
            'totalUserCash' => $this->totalUserCash()
        ]);
    }

    public function filterData()
    {
        // Jika salah satu tanggal kosong, tetap gunakan default
        $this->startDate = $this->startDate ?: now()->startOfYear()->toDateString();
        $this->endDate = $this->endDate ?: now()->endOfYear()->toDateString();
        $this->area_id = $this->area_id ?: 'all';
    }

    public function totalOmzet() {
        return DB::table('pendapatans')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->sum('total') ?? 0;
    }

    public function totalPemasukan($jenis) {
        if ($jenis == 'kas-besar') {
            $data = DB::table('kas_besars')
                ->join('list_kas_besars', 'kas_besars.id', '=', 'list_kas_besars.kas_besar_id')
                ->where('kas_besars.category', 'Pemasukan')
                ->whereBetween('list_kas_besars.created_at', [$this->startDate, $this->endDate])
                ->sum('list_kas_besars.total') ?? 0;
        } elseif ($jenis == 'kas-kecil') {
            $data = DB::table('kas_kecils')
                ->join('list_kas_kecils', 'kas_kecils.id', '=', 'list_kas_kecils.kas_kecil_id')
                ->when($this->area_id !== 'all', function ($query) {
                    $query->where('kas_kecils.area_id', $this->area_id);
                })
                ->where('kas_kecils.category', 'Pemasukan')
                ->whereBetween('list_kas_kecils.created_at', [$this->startDate, $this->endDate])
                ->sum('list_kas_kecils.total') ?? 0;
        }
        return $data;
    }

    public function totalPengeluaran($jenis) {
        if ($jenis == 'kas-besar') {
            $data = DB::table('kas_besars')
                ->join('list_kas_besars', 'kas_besars.id', '=', 'list_kas_besars.kas_besar_id')
                ->where('kas_besars.category', 'Pengeluaran')
                ->whereBetween('list_kas_besars.created_at', [$this->startDate, $this->endDate])
                ->sum('list_kas_besars.total') ?? 0;
        } elseif ($jenis == 'kas-kecil') {
            $data = DB::table('kas_kecils')
                ->join('list_kas_kecils', 'kas_kecils.id', '=', 'list_kas_kecils.kas_kecil_id')
                ->when($this->area_id !== 'all', function ($query) {
                    $query->where('kas_kecils.area_id', $this->area_id);
                })
                ->where('kas_kecils.category', 'Pengeluaran')
                ->whereBetween('list_kas_kecils.created_at', [$this->startDate, $this->endDate])
                ->sum('list_kas_kecils.total') ?? 0;
        }


        return $data;
    }

    public function unitTerjual() {
        return DB::table('customers')
            ->join('prospective_customers', 'customers.prospective_customer_id', '=', 'prospective_customers.id')
            ->when($this->area_id !== 'all', function ($query) {
                $query->where('prospective_customers.area_id', $this->area_id);
            })
            ->whereBetween('customers.created_at', [$this->startDate, $this->endDate])
            ->count();
    }

    public function totalKaryawan() {
        return DB::table('employees')
            ->join('structures', 'employees.id', '=', 'structures.employee_id')
            ->when($this->area_id !== 'all', function ($query) {
                $query->where('structures.area_id', $this->area_id);
            })
            ->where('employees.active', 1)
            ->whereBetween('employees.created_at', [$this->startDate, $this->endDate]) // ini dia
            ->distinct('employees.id')
            ->count('employees.id');
    }

    public function totalCalonUser() {
        return DB::table('prospective_customers')
            ->when($this->area_id !== 'all', function ($query) {
                $query->where('area_id', $this->area_id);
            })
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();
    }

    public function totalUserSpr() {
        return DB::table('customers')
            ->join('prospective_customers', 'customers.prospective_customer_id', '=', 'prospective_customers.id')
            ->when($this->area_id !== 'all', function ($query) {
                $query->where('prospective_customers.area_id', $this->area_id);
            })
            ->whereBetween('customers.created_at', [$this->startDate, $this->endDate])
            ->where('status_pengajuan_user', 'SPR')
            ->count();
    }

    public function totalUserSp3k() {
        return DB::table('customers')
            ->join('prospective_customers', 'customers.prospective_customer_id', '=', 'prospective_customers.id')
            ->when($this->area_id !== 'all', function ($query) {
                $query->where('prospective_customers.area_id', $this->area_id);
            })
            ->whereBetween('customers.created_at', [$this->startDate, $this->endDate])
            ->where('status_pengajuan_user', 'SP3K')
            ->count();
    }

    public function totalUserAkad() {
        return DB::table('customers')
            ->join('prospective_customers', 'customers.prospective_customer_id', '=', 'prospective_customers.id')
            ->when($this->area_id !== 'all', function ($query) {
                $query->where('prospective_customers.area_id', $this->area_id);
            })
            ->whereBetween('customers.created_at', [$this->startDate, $this->endDate])
            ->where('status_pengajuan_user', 'AKAD')
            ->count();
    }

    public function totalUserCash() {
        return DB::table('customers')
            ->join('prospective_customers', 'customers.prospective_customer_id', '=', 'prospective_customers.id')
            ->when($this->area_id !== 'all', function ($query) {
                $query->where('prospective_customers.area_id', $this->area_id);
            })
            ->whereBetween('customers.created_at', [$this->startDate, $this->endDate])
            ->where('status_penjualan', 'CASH')
            ->count();
    }
}
