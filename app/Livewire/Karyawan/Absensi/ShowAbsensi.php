<?php

namespace App\Livewire\Karyawan\Absensi;

use App\Models\Absensi;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowAbsensi extends Component
{
    public $id, $show;
    public function mount($id) {
        $this->id = $id;
        $list = Absensi::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'employee_id' => 'Nama Karyawan',
            'date' => 'Tanggal',
            'check_in' => 'Absen Masuk',
            'check_out' => 'Absen Keluar'
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'employee_id' => $list->employee->name ?? '-',
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }
    public function render()
    {
        return view('livewire.karyawan.absensi.show-absensi');
    }
}
