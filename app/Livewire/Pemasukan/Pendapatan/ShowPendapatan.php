<?php

namespace App\Livewire\Pemasukan\Pendapatan;

use App\Models\Pendapatan;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowPendapatan extends Component
{
    public $id, $show;

    public function mount($id) {
        $this->id = $id;
        $list = Pendapatan::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'tanggal' => 'Tanggal',
            'type_of_income_id' => 'Jenis Pemasukan',
            'customer_id' => 'User',
            'keterangan' => 'Keterangan',
            'total' => 'Total'
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'type_of_income_id' => $list->typeOfIncome->name,
                    'customer_id' => "NIK : " . $list->customer->prospectiveCustomer->identification_number . "\n NAMA : " . $list->customer->prospectiveCustomer->name . "\n ALAMAT : " . $list->customer->prospectiveCustomer->address,
                    'total' => 'Rp ' . number_format($list->total, 0, ',', '.'),
                    default => $value ?? '-'
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }
    public function render()
    {
        return view('livewire.pemasukan.pendapatan.show-pendapatan');
    }
}
