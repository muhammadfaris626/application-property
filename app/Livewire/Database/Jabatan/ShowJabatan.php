<?php

namespace App\Livewire\Database\Jabatan;

use App\Models\Position;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowJabatan extends Component
{
    public $id, $show;
    public function render()
    {
        return view('livewire.database.jabatan.show-jabatan');
    }

    public function mount($id) {
        $this->id = $id;
        $list = Position::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'name' => 'Nama Jabatan',
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
