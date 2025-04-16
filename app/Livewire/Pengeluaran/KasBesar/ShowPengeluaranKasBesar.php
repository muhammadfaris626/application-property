<?php

namespace App\Livewire\Pengeluaran\KasBesar;

use App\Models\KasBesar;
use App\Models\ListKasBesar;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowPengeluaranKasBesar extends Component
{
    public $id, $show, $fetch;

    public function mount($id) {
        $this->id = $id;
        $list = KasBesar::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'category' => 'Kategori',
            'date' => 'Tanggal',
            'employee_id' => 'Penanggung Jawab'
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
        $this->fetch = ListKasBesar::where('kas_besar_id', $id)->get();
    }

    public function render()
    {
        return view('livewire.pengeluaran.kas-besar.show-pengeluaran-kas-besar');
    }
}
