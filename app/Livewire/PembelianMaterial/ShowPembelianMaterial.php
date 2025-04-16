<?php

namespace App\Livewire\PembelianMaterial;

use App\Models\ListPurchaseOfMaterial;
use App\Models\PurchaseOfMaterial;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowPembelianMaterial extends Component
{
    public $id, $show, $fetch;

    public function mount($id) {
        $this->id = $id;
        $list = PurchaseOfMaterial::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'invoice_number' => 'Nomor Faktur',
            'date' => 'Tanggal',
            'supplier_id' => 'Nama Supplier',
            'employee_id' => 'Penerima Barang'
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'supplier_id' => $list->supplier->name ?? '-',
                    'employee_id' => $list->employee->name ?? '-',
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
        $this->fetch = ListPurchaseOfMaterial::where('purchase_of_material_id', $id)->get();
    }

    public function render()
    {
        return view('livewire.pembelian-material.show-pembelian-material');
    }
}
