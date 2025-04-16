<?php

namespace App\Livewire\Pengaturan\Perizinan;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowPerizinan extends Component
{
    public $id, $show;
    public function mount($id) {
        $this->id = $id;
        $list = Permission::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'name' => 'Nama',
            'guard' => 'Guard'
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
    public function render()
    {
        return view('livewire.pengaturan.perizinan.show-perizinan');
    }
}
