<?php

namespace App\Livewire\PembelianMaterial;

use App\Http\Requests\PurchaseOfMaterialRequest;
use App\Models\Employee;
use App\Models\ListPurchaseOfMaterial;
use App\Models\Material;
use App\Models\PurchaseOfMaterial;
use App\Models\Supplier;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class EditPembelianMaterial extends Component
{
    public $id, $invoice_number, $date, $supplier_id, $employee_id;
    public $fetchSupplier, $fetchKaryawan, $search = "", $fetchMaterial;
    public $allMaterials = [];

    public function mount($id) {
        $this->id = $id;
        $data = PurchaseOfMaterial::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only('id', 'invoice_number', 'date', 'supplier_id', 'employee_id'));
        $this->fetchSupplier = Supplier::all();
        $this->fetchKaryawan = Employee::where('active', 1)->get();
        $this->allMaterials = ListPurchaseOfMaterial::where('purchase_of_material_id', $id)
            ->get()
            ->map(function ($material) {
                return [
                    'material_id' => $material->material_id,
                    'quantity' => $material->quantity,
                    'price' => $material->price,
                    'total_price' => number_format($material->total_price, 0, ',', '.'),
                ];
            })->toArray();
        $this->fetchMaterial = Material::all();
        foreach ($this->allMaterials as $i => $material) {
            $qty = (int) ($material['quantity'] ?? 0);
            $price = (int) ($material['price'] ?? 0);
            $this->allMaterials[$i]['total_price'] = $qty * $price;
        }
    }

    public function addMaterial() {
        $this->validate([
            'allMaterials.*.material_id' => 'required',
            'allMaterials.*.quantity' => 'required',
            'allMaterials.*.price' => 'required',
        ], [
            'allMaterials.*.material_id.required' => 'Kolom material wajib diisi.',
            'allMaterials.*.quantity.required' => 'Kolom jumlah wajib diisi.',
            'allMaterials.*.price.required' => 'Kolom harga wajib diisi.',
        ]);
        $this->allMaterials[] = ['material_id' => '', 'quantity' => '', 'price' => '', 'total_price' => ''];
    }

    public function removeMaterial($index) {
        unset($this->allMaterials[$index]);
        $this->allMaterials = array_values($this->allMaterials);
    }

    public function updatedAllMaterials($value, $key) {
        logger("updatedAllMaterials", [$key => $value]);
        $keys = explode('.', $key);
        if (count($keys) === 2 && in_array($keys[1], ['quantity', 'price'])) {
            $index = $keys[0];
            $qty = (int) ($this->allMaterials[$index]['quantity'] ?? 0);
            $price = (int) ($this->allMaterials[$index]['price'] ?? 0);
            $this->allMaterials[$index]['total_price'] = $qty * $price;
        }
    }
    public function render()
    {
        return view('livewire.pembelian-material.edit-pembelian-material');
    }

    public function update() {
        if (empty($this->allMaterials)) {
            LivewireAlert::text('Silahkan tambah material terlebih dahulu.')->error()->toast()->position('top-end')->show();
            return back();
        }
        $this->validate([
            'invoice_number' => 'required|unique:purchase_of_materials,invoice_number,' . $this->id,
            'date' => 'required',
            'supplier_id' => 'required',
            'employee_id' => 'required',
            'allMaterials.*.material_id' => 'required',
            'allMaterials.*.quantity' => 'required',
            'allMaterials.*.price' => 'required',
        ], [
            'invoice_number.required' => 'Kolom nomor faktur wajib diisi.',
            'invoice_number.unique' => 'Nomor faktur sudah ada.',
            'date.required' => 'Kolom tanggal wajib diisi.',
            'supplier_id.required' => 'Kolom supplier wajib diisi.',
            'employee_id.required' => 'Kolom penerima barang wajib diisi.',
            'allMaterials.*.material_id.required' => 'Kolom material wajib diisi.',
            'allMaterials.*.quantity.required' => 'Kolom jumlah wajib diisi.',
            'allMaterials.*.price.required' => 'Kolom harga wajib diisi.',
        ]);
        // Update data utama
        $purchase = PurchaseOfMaterial::findOrFail($this->id);
        $purchase->update([
            'invoice_number' => $this->invoice_number,
            'date' => $this->date,
            'supplier_id' => $this->supplier_id,
            'employee_id' => $this->employee_id
        ]);

        // Hapus semua material lama
        ListPurchaseOfMaterial::where('purchase_of_material_id', $this->id)->delete();

        // Simpan ulang material baru
        foreach ($this->allMaterials as $material) {
            ListPurchaseOfMaterial::create([
                'purchase_of_material_id' => $this->id,
                'material_id' => $material['material_id'],
                'quantity' => (int) $material['quantity'],
                'price' => (int) $material['price'],
                'total_price' => (int) str_replace(".", "", $material['total_price']),
            ]);
        }

        session()->flash('success', 'Data berhasil diubah.');
        return to_route('pembelian-material.index');
    }
}
