<?php

namespace App\Livewire\Database\MaterialKategori;

use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowMaterialKategori extends Component
{
    public $id, $show;
    public function render()
    {
        return view('livewire.database.material-kategori.show-material-kategori');
    }

    public function mount($id) {
        $this->id = $id;
        $list = MaterialCategory::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'code' => 'Kode Kategori Material',
            'name' => 'Nama Kategori Material',
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
