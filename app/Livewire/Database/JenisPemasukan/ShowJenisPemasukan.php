<?php

namespace App\Livewire\Database\JenisPemasukan;

use App\Models\TypeOfIncome;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowJenisPemasukan extends Component
{
    public $id, $show;
    public function render()
    {
        return view('livewire.database.jenis-pemasukan.show-jenis-pemasukan');
    }

    public function mount($id) {
        $this->id = $id;
        $list = TypeOfIncome::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'name' => 'Nama',
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
