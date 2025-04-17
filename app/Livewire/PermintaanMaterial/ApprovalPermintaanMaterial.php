<?php

namespace App\Livewire\PermintaanMaterial;

use App\Models\ApprovalHistory;
use App\Models\ApprovalStep;
use App\Models\ListPermintaanMaterial;
use App\Models\PermintaanMaterial;
use App\Models\Position;
use App\Models\Structure;
use App\Models\User;
use App\Notifications\PermintaanMaterialNotification;
use Livewire\Component;

class ApprovalPermintaanMaterial extends Component
{
    public $id, $show, $fetch;

    public function mount($id) {
        $this->id = $id;
        $list = PermintaanMaterial::find($id);
        $fieldNames = [
            'date' => 'Tanggal',
            'ro_number' => 'Nomor RO',
            'employee_id' => 'Yang Mengajukan',
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
        $this->fetch = ListPermintaanMaterial::with('material')->where('permintaan_material_id', $id)->get()->toArray();
    }

    public function render()
    {
        return view('livewire.permintaan-material.approval-permintaan-material');
    }

    public function persetujuan() {

        $approval = ApprovalHistory::where('approvable_id', $this->id)->where('approvable_type', 'App\Models\PermintaanMaterial')->where('status', 1)->first();
        $typeAgreement = $approval->approvalStep->type_of_agreement;
        if ($typeAgreement == 'Pemeriksa') {
            $this->validate([
                'fetch.*.approved_quantity' => 'required'
            ], [
                'fetch.*.approved_quantity.required' => 'Kolom yang disetujui wajib diisi.'
            ]);
            for ($i=0; $i < count($this->fetch); $i++) {
                ListPermintaanMaterial::findOrFail($this->fetch[$i]['id'])->update([
                    'approved_quantity' => $this->fetch[$i]['approved_quantity']
                ]);
            }
        }
        $step = $approval->approvalStep->step;
        $approval->update([
            'marker' => 'disetujui',
            'status' => 2,
        ]);
        $nextStep = ApprovalStep::where('approval_flow_id', $approval->approvalStep->approval_flow_id)->where('step', $step + 1)->first();
        if (!empty($nextStep)) {
            $nextApproval = ApprovalHistory::where('approvable_id', $this->id)->where('approvable_type', 'App\Models\PermintaanMaterial')->where('approval_step_id', $nextStep->id)->first();
            $nextApproval->update([
                'status' => 1
            ]);

            $struktur = Structure::where('employee_id', $nextApproval->approved_by)->first();
            $penerima = User::where('employee_id', $struktur->employee_id)->first();
            $create = PermintaanMaterial::where('id', $nextApproval->approvable_id)->first();
            $penerima->notify(new PermintaanMaterialNotification($create));
        }

        session()->flash('success', 'Permintaan telah disetujui.');
        return to_route('permintaan-material.index');
    }
}
