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

class CreatePembelianMaterial extends Component
{
    public $invoice_number, $date, $supplier_id, $employee_id, $action;
    // public $material_id, $quantity, $price, $total_price;
    public $fetchSupplier, $fetchKaryawan, $fetchMaterial;
    public $allMaterials = [];
    public $data;
    public $search = "";

    public function mount() {
        $this->fetchSupplier = Supplier::all();
        $this->fetchKaryawan = Employee::where('active', 1)->get();
        $this->fetchMaterial = Material::all();
    }

    public function render()
    {
        Gate::authorize('create', PurchaseOfMaterial::class);
        return view('livewire.pembelian-material.create-pembelian-material');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
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

    public function updated($propertyName) {
        if (str($propertyName)->startsWith('allMaterials')) {
            foreach ($this->allMaterials as $key => $material) {
                $quantity = isset($material['quantity']) ? (int) $material['quantity'] : 0;
                $price = isset($material['price']) ? (int) $material['price'] : 0;
                $this->allMaterials[$key]['total_price'] = $quantity * $price;
            }
        }
    }

    public function store() {
        $request = new PurchaseOfMaterialRequest();
        $this->validate($request->rules(), $request->messages());
        if (empty($this->allMaterials)) {
            LivewireAlert::text('Silahkan tambah material terlebih dahulu.')->error()->toast()->position('top-end')->show();
            return back();
        }

        $this->validate([
            'allMaterials.*.material_id' => 'required',
            'allMaterials.*.quantity' => 'required',
            'allMaterials.*.price' => 'required',
        ], [
            'allMaterials.*.material_id.required' => 'Kolom material wajib diisi.',
            'allMaterials.*.quantity.required' => 'Kolom jumlah wajib diisi.',
            'allMaterials.*.price.required' => 'Kolom harga wajib diisi.',
        ]);

        $create = PurchaseOfMaterial::create([
            'invoice_number' => $this->invoice_number,
            'date' => $this->date,
            'supplier_id' => $this->supplier_id,
            'employee_id' => $this->employee_id
        ]);

        for ($i=0; $i < count($this->allMaterials); $i++) {
            ListPurchaseOfMaterial::create([
                'purchase_of_material_id' => $create->id,
                'material_id' => $this->allMaterials[$i]['material_id'],
                'quantity' => $this->allMaterials[$i]['quantity'],
                'price' => $this->allMaterials[$i]['price'],
                'total_price' => $this->allMaterials[$i]['total_price'],
            ]);
        }

        $this->dispatch('resetDropdown');
        $this->reset(['invoice_number', 'date', 'supplier_id', 'employee_id', 'allMaterials']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('pembelian-material.index');
        }
    }
}
