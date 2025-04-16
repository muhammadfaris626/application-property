<?php

namespace App\Livewire\Pengaturan\Persetujuan\ApprovalStep;

use App\Http\Requests\ApprovalStepRequest;
use App\Models\ApprovalStep;
use App\Models\Area;
use App\Models\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateApprovalStep extends Component
{
    public $id, $step = "", $area_id, $position_id, $type_of_agreement = "", $action;
    public $fetchPosition, $fetchArea;
    public function mount($id) {
        $this->fetchPosition = Position::all();
        $this->fetchArea = Area::all();
        $this->id = $id;
    }
    public function render()
    {
        return view('livewire.pengaturan.persetujuan.approval-step.create-approval-step');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new ApprovalStepRequest();
        $this->validate($request->rules(), $request->messages());
        ApprovalStep::create([
            'approval_flow_id' => $this->id,
            'step' => $this->step,
            'area_id' => $this->area_id,
            'position_id' => $this->position_id,
            'type_of_agreement' => $this->type_of_agreement
        ]);
        $this->dispatch('resetDropdown');
        $this->reset(['step', 'position_id', 'type_of_agreement']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('persetujuan.show', $this->id);
        }
    }
}
