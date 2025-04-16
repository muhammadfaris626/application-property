<?php

namespace App\Livewire\Database\Material;

use App\Models\Material;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowMaterial extends Component
{
    public $id, $show;
    public function render()
    {
        return view('livewire.database.material.show-material');
    }

    public function mount($id) {
        $this->id = $id;
        $list = Material::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'material_category_id' => 'Kategori Material',
            'name' => 'Nama Material',
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'material_category_id' => $list->materialCategory->name ?? '-',
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }
}
