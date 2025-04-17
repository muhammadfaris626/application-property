<?php

namespace App\Livewire\PermintaanMaterial;

use App\Http\Requests\PermintaanMaterialRequest;
use App\Models\ApprovalFlow;
use App\Models\ApprovalStep;
use App\Models\ListPermintaanMaterial;
use App\Models\Material;
use App\Models\PermintaanMaterial;
use App\Models\Position;
use App\Models\Structure;
use App\Models\User;
use App\Notifications\PermintaanMaterialNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreatePermintaanMaterial extends Component
{
    public $date, $ro_number, $action, $search = "";
    public $allMaterials = [], $fetchMaterial;

    public function mount() {
        $this->fetchMaterial = Material::all();
    }

    public function render()
    {
        Gate::authorize('create', PermintaanMaterial::class);
        return view('livewire.permintaan-material.create-permintaan-material');
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

    public function store() {
        $request = new PermintaanMaterialRequest();
        $this->validate($request->rules(), $request->messages());
        if (empty($this->allMaterials)) {
            LivewireAlert::text('Silahkan tambah material terlebih dahulu.')->error()->toast()->position('top-end')->show();
            return back();
        }

        $this->validate([
            'allMaterials.*.material_id' => 'required',
            'allMaterials.*.quantity' => 'required'
        ], [
            'allMaterials.*.material_id.required' => 'Kolom material wajib diisi.',
            'allMaterials.*.quantity.required' => 'Kolom jumlah wajib diisi.'
        ]);
        $format = 'RO-' . date('mdY') . '-' . str_pad((PermintaanMaterial::max('id') + 1), 5, '0', STR_PAD_LEFT);
        $create = PermintaanMaterial::create([
            'date' => $this->date,
            'ro_number' => $format,
            'employee_id' => Auth::user()->employee_id,
            'area_id' => Auth::user()->area_id,
        ]);

        for ($i=0; $i < count($this->allMaterials); $i++) {
            ListPermintaanMaterial::create([
                'permintaan_material_id' => $create->id,
                'material_id' => $this->allMaterials[$i]['material_id'],
                'quantity' => $this->allMaterials[$i]['quantity']
            ]);
        }

        $flow = ApprovalFlow::where('model_type', 'App\Models\PermintaanMaterial')->first();
        $step = ApprovalStep::where('approval_flow_id', $flow->id)->where('step', 1)->first();

        $jabatan = Position::where('id', $step->position_id)->first();
        $struktur = Structure::where('position_id', $jabatan->id)->first();
        $penerima = User::where('employee_id', $struktur->employee_id)->first();
        $penerima->notify(new PermintaanMaterialNotification($create));

        $this->dispatch('resetDropdown');
        $this->reset(['date', 'ro_number', 'allMaterials']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('permintaan-material.index');
        }
    }
}
