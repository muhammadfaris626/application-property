<?php

namespace App\Livewire\Pengeluaran\PengajuanInvoice;

use App\Models\PengajuanInvoice;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowPengajuanInvoice extends Component
{
    public $id, $show;

    public function mount($id) {
        $this->id = $id;
        $list = PengajuanInvoice::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'date' => 'Tanggal',
            'employee_id' => 'Penanggung Jawab',
            'price' => 'Harga',
            'desc' => 'Keterangan',
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'employee_id' => $list->employee->name ?? '-',
                    'price' => 'Rp ' . number_format($list->price, 0, ',', '.'),
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }

    public function render()
    {
        return view('livewire.pengeluaran.pengajuan-invoice.show-pengajuan-invoice');
    }
}
