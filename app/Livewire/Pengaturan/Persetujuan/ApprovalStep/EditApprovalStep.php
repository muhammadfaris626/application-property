<?php

namespace App\Livewire\Pengaturan\Persetujuan\ApprovalStep;

use App\Http\Requests\ApprovalStepRequest;
use App\Models\ApprovalStep;
use App\Models\Area;
use App\Models\Position;
use Livewire\Component;

class EditApprovalStep extends Component
{
    public $id, $step, $area_id, $position_id, $type_of_agreement, $approval_flow_id;
    public $fetchPosition, $fetchArea;
    public function mount($id) {
        $data = ApprovalStep::findOrFail($id);
        $this->fill($data->only(['id', 'step', 'area_id', 'position_id', 'type_of_agreement']));
        $this->fetchPosition = Position::all();
        $this->fetchArea = Area::all();
        $this->approval_flow_id = $data->approval_flow_id;
    }
    public function render()
    {
        return view('livewire.pengaturan.persetujuan.approval-step.edit-approval-step');
    }

    public function update() {
        $request = new ApprovalStepRequest();
        $this->validate($request->rules(), $request->messages());
        ApprovalStep::findOrFail($this->id)->update([
            'step' => $this->step,
            'area_id' => $this->area_id,
            'position_id' => $this->position_id,
            'type_of_agreement' => $this->type_of_agreement
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('persetujuan.show', $this->approval_flow_id);
    }
}
