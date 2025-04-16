<?php

namespace App\Livewire\Database\JenisRumah;

use App\Models\TypeOfHouse;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowJenisRumah extends Component
{
    public $id, $show;
    public function render()
    {
        return view('livewire.database.jenis-rumah.show-jenis-rumah');
    }

    public function mount($id) {
        $this->id = $id;
        $list = TypeOfHouse::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'area_id' => 'Nama Area',
            'code' => 'Kode',
            'name' => 'Nama',
            'price' => 'Harga',
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'area_id' => $list->area->name ?? '-',
                    'price' => 'Rp ' . number_format($list->price, 0, ',', '.'),
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }
}
