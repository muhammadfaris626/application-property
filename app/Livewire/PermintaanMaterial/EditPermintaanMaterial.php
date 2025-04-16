<?php

namespace App\Livewire\PermintaanMaterial;

use App\Models\ListPermintaanMaterial;
use App\Models\Material;
use App\Models\PermintaanMaterial;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class EditPermintaanMaterial extends Component
{
    public $id, $date, $ro_number;
    public $fetchMaterial, $search = "";
    public $allMaterials = [];

    public function mount($id) {
        $this->id = $id;
        $data = PermintaanMaterial::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only('id', 'date', 'ro_number'));
        $this->fetchMaterial = Material::all();
        $this->allMaterials = ListPermintaanMaterial::where('permintaan_material_id', $id)
            ->get()
            ->map(function($material) {
                return [
                    'material_id' => $material->material_id,
                    'quantity' => $material->quantity,
                ];
            })->toArray();
    }

    public function render()
    {
        return view('livewire.permintaan-material.edit-permintaan-material');
    }

    public function addMaterial() {
        $this->validate([
            'allMaterials.*.material_id' => 'required',
            'allMaterials.*.quantity' => 'required',
        ], [
            'allMaterials.*.material_id.required' => 'Kolom material wajib diisi.',
            'allMaterials.*.quantity.required' => 'Kolom jumlah wajib diisi.',
        ]);
        $this->allMaterials[] = ['material_id' => '', 'quantity' => ''];
    }

    public function removeMaterial($index) {
        unset($this->allMaterials[$index]);
        $this->allMaterials = array_values($this->allMaterials);
    }

    public function update() {
        if (empty($this->allMaterials)) {
            LivewireAlert::text('Silahkan tambah material terlebih dahulu.')->error()->toast()->position('top-end')->show();
            return back();
        }
        $this->validate([
            'date' => 'required',
            'allMaterials.*.material_id' => 'required',
            'allMaterials.*.quantity' => 'required',
        ], [
            'date.required' => 'Kolom tanggal wajib diisi.',
            'allMaterials.*.material_id.required' => 'Kolom material wajib diisi.',
            'allMaterials.*.quantity.required' => 'Kolom jumlah wajib diisi.',
        ]);
        // Update data utama
        $purchase = PermintaanMaterial::findOrFail($this->id);
        $purchase->update([
            'date' => $this->date,
            'ro_number' => $this->ro_number,
        ]);

        // Hapus semua material lama
        ListPermintaanMaterial::where('permintaan_material_id', $this->id)->delete();

        // Simpan ulang material baru
        foreach ($this->allMaterials as $material) {
            ListPermintaanMaterial::create([
                'permintaan_material_id' => $this->id,
                'material_id' => $material['material_id'],
                'quantity' => $material['quantity'],
            ]);
        }

        session()->flash('success', 'Data berhasil diubah.');
        return to_route('permintaan-material.index');
    }
}
