<?php

namespace App\Livewire\Pengeluaran\PengajuanInvoice;

use App\Models\ApprovalHistory;
use App\Models\ApprovalStep;
use App\Models\PengajuanInvoice;
use Livewire\Component;

class ApprovalPengajuanInvoice extends Component
{
    public $id, $show, $fetch, $approved_price;

    public function mount($id) {
        $this->id = $id;
        $this->show = PengajuanInvoice::find($id);
    }

    public function render()
    {
        return view('livewire.pengeluaran.pengajuan-invoice.approval-pengajuan-invoice');
    }

    public function persetujuan() {
        $approval = ApprovalHistory::where('approvable_id', $this->id)->where('approvable_type', 'App\Models\PengajuanInvoice')->where('status', 1)->first();
        $typeAgreement = $approval->approvalStep->type_of_agreement;
        if ($typeAgreement == 'Pemeriksa') {
            $this->validate([
                'approved_price' => 'required'
            ], [
                'approved_price.required' => 'Kolom yang disetujui wajib diisi.'
            ]);
            $update = PengajuanInvoice::find($this->id);
            $update->update([
                'approved_price' => str_replace('.', '', $this->approved_price)
            ]);
        }
        $step = $approval->approvalStep->step;
        $approval->update([
            'marker' => 'disetujui',
            'status' => 2,
        ]);
        $nextStep = ApprovalStep::where('approval_flow_id', $approval->approvalStep->approval_flow_id)->where('step', $step + 1)->first();
        if (!empty($nextStep)) {
            $nextApproval = ApprovalHistory::where('approvable_id', $this->id)->where('approvable_type', 'App\Models\PengajuanInvoice')->where('approval_step_id', $nextStep->id)->first();
            $nextApproval->update([
                'status' => 1
            ]);
        }
        session()->flash('success', 'Permintaan telah disetujui.');
        return to_route('pengajuan-invoice.index');
    }
}
