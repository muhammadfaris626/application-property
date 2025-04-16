<?php

namespace App\Livewire\PermintaanMaterial;

use App\Models\ListPermintaanMaterial;
use App\Models\PermintaanMaterial;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowPermintaanMaterial extends Component
{
    public $id, $show, $fetch;
    public function mount($id) {
        $this->id = $id;
        $list = PermintaanMaterial::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'date' => 'Tanggal',
            'ro_number' => 'Nomor RO',
            'employee_id' => 'Yang Mengajukan',
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
        $this->fetch = ListPermintaanMaterial::where('permintaan_material_id', $id)->get();
    }
    public function render()
    {
        return view('livewire.permintaan-material.show-permintaan-material');
    }
}
