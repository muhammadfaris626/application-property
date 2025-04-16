<?php

namespace App\Livewire\Karyawan\Mutasi;

use App\Models\Mutation;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowMutasi extends Component
{
    public $id, $show;
    public function mount($id) {
        $this->id = $id;
        $list = Mutation::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'date' => 'Tanggal',
            'employee_id' => 'Nama Karyawan',
            'from_area_id' => 'Area Sebelumnya',
            'to_area_id' => 'Mutasi Ke'
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'employee_id' => $list->employee->name ?? '-',
                    'from_area_id' => $list->fromArea->name,
                    'to_area_id' => $list->toArea->name,
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }
    public function render()
    {
        return view('livewire.karyawan.mutasi.show-mutasi');
    }
}
