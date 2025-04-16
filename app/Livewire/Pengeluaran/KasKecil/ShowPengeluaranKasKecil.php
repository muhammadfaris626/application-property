<?php

namespace App\Livewire\Pengeluaran\KasKecil;

use App\Models\KasKecil;
use App\Models\ListKasKecil;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowPengeluaranKasKecil extends Component
{
    public $id, $show, $fetch;

    public function mount($id) {
        $this->id = $id;
        $list = KasKecil::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'category' => 'Kategori',
            'date' => 'Tanggal',
            'employee_id' => 'Penanggung Jawab',
            'area_id' => 'Area'
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'employee_id' => $list->employee->name ?? '-',
                    'area_id' => $list->area->name ?? '-',
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
        $this->fetch = ListKasKecil::where('kas_kecil_id', $id)->get();
    }

    public function render()
    {
        return view('livewire.pengeluaran.kas-kecil.show-pengeluaran-kas-kecil');
    }
}
