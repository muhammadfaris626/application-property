<?php

namespace App\Livewire\Database\Supplier;

use App\Models\Supplier;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowSupplier extends Component
{
    public $id, $show;
    public function render()
    {
        return view('livewire.database.supplier.show-supplier');
    }

    public function mount($id) {
        $this->id = $id;
        $list = Supplier::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'name' => 'Nama Supplier',
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
