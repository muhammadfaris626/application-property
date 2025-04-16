<?php

namespace App\Livewire\Database\Area;

use App\Models\Area;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowArea extends Component
{
    public $id, $show;

    public function render()
    {

        return view('livewire.database.area.show-area', [
            'show' => $this->show
        ]);
    }

    public function mount($id) {
        $this->id = $id;
        $list = Area::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'name' => 'Nama Area',
            'address' => 'Alamat',
            'created_at' => 'Tanggal Dibuat',
            'updated_at' => 'Tanggal Diubah',
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }
}
