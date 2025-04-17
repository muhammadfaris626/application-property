<?php

namespace App\Livewire\Laporan\Absensi;

use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IndexLaporanAbsensi extends Component
{
    public $startDate;
    public $endDate;
    public $filterClicked = false;

    public function mount() {
        $this->startDate = now()->startOfYear()->toDateString();
        $this->endDate = now()->endOfYear()->toDateString();
    }

    public function render()
    {
        return view('livewire.laporan.absensi.index-laporan-absensi', [
            'top5KaryawanRajin' => $this->top5KaryawanRajin(),
            'top5KaryawanTerlambat' => $this->top5KaryawanTerlambat(),
            'fetchData' => $this->fetchData()
        ]);
    }

    public function applyFilter()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $this->filterClicked = true;
    }

    public function top5KaryawanRajin()
    {
        return Absensi::select(
            'employees.name',
            'employees.id as employee_id',
            'areas.name as area_name',
            DB::raw('COUNT(*) as total_absensi')
        )
        ->join('employees', 'absensis.employee_id', '=', 'employees.id')
        ->join('structures', 'absensis.employee_id', '=', 'structures.employee_id')
        ->join('areas', 'structures.area_id', '=', 'areas.id')
        ->whereTime('check_in', '<=', '08:00:00')
        ->whereTime('check_out', '>=', '17:00:00')
        ->whereBetween('absensis.date', [$this->startDate, $this->endDate])
        ->groupBy('employees.id', 'employees.name', 'areas.name')
        ->orderByDesc('total_absensi')
        ->limit(5)
        ->get();
    }

    public function top5KaryawanTerlambat()
    {
        return Absensi::select(
            'employees.name',
            'employees.id as employee_id',
            'areas.name as area_name',
            DB::raw('COUNT(*) as total_absensi')
        )
        ->join('employees', 'absensis.employee_id', '=', 'employees.id')
        ->join('structures', 'absensis.employee_id', '=', 'structures.employee_id')
        ->join('areas', 'structures.area_id', '=', 'areas.id')
        ->whereTime('check_in', '>', '08:00:00')
        ->whereBetween('absensis.date', [$this->startDate, $this->endDate])
        ->groupBy('employees.id', 'employees.name', 'areas.name')
        ->orderByDesc('total_absensi')
        ->limit(5)
        ->get();
    }

    public function fetchData() {
        $absensiData = Absensi::select(
            'employees.id as employee_id',
            'employees.name as employee_name',
            'areas.name as area_name',
            'absensis.date',
            'absensis.check_in',
            'absensis.check_out'
        )
        ->join('employees', 'absensis.employee_id', '=', 'employees.id')
        ->join('structures', 'absensis.employee_id', '=', 'structures.employee_id')
        ->join('areas', 'structures.area_id', '=', 'areas.id')
        ->whereBetween('absensis.date', [$this->startDate, $this->endDate])
        ->get();

        $rekap = [];

        foreach ($absensiData as $data) {
            $id = $data->employee_id;

            if (!isset($rekap[$id])) {
                $rekap[$id] = [
                    'name' => $data->employee_name,
                    'area' => $data->area_name,
                    'ontime' => 0,
                    'terlambat' => 0,
                    'tidak_absen_masuk' => 0,
                    'tidak_absen_pulang' => 0,
                ];
            }

            // Hitung ontime/terlambat/tidak absen masuk
            if (is_null($data->check_in)) {
                $rekap[$id]['tidak_absen_masuk']++;
            } elseif ($data->check_in > '08:00:00') {
                $rekap[$id]['terlambat']++;
            } else {
                $rekap[$id]['ontime']++;
            }

            // Hitung tidak absen pulang
            if (is_null($data->check_out)) {
                $rekap[$id]['tidak_absen_pulang']++;
            }
        }

        return array_values($rekap);
    }
}
