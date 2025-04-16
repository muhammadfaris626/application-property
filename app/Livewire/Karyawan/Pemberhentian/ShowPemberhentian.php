<?php

namespace App\Livewire\Karyawan\Pemberhentian;

use App\Models\Termination;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowPemberhentian extends Component
{
    public $id, $show;
    public function mount($id) {
        $this->id = $id;
        $list = Termination::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'date' => 'Tanggal',
            'employee_id' => 'Nama Karyawan',
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
        return view('livewire.karyawan.pemberhentian.show-pemberhentian');
    }
}
