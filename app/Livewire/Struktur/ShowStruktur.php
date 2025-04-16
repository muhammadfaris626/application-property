<?php

namespace App\Livewire\Struktur;

use App\Models\Structure;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowStruktur extends Component
{
    public $id, $show;
    public function render()
    {
        return view('livewire.struktur.show-struktur');
    }

    public function mount($id) {
        $this->id = $id;
        $list = Structure::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'employee_id' => 'Nama Karyawan',
            'position_id' => 'Jabatan',
            'area_id' => 'Area',
            'employee_number' => 'Nomor Identitas Kepegawaian'
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'employee_id' => $list->employee->name ?? '-',
                    'position_id' => $list->position->name,
                    'area_id' => $list->area->name,
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }
}
