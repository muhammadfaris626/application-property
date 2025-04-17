<?php

namespace App\Observers;

use App\Models\ApprovalFlow;
use App\Models\ApprovalHistory;
use App\Models\ApprovalStep;
use App\Models\PengajuanInvoice;
use App\Models\Structure;

class PengajuanInvoiceObserver
{
    /**
     * Handle the PengajuanInvoice "created" event.
     */
    public function created(PengajuanInvoice $pengajuanInvoice): void
    {
        $checkApprovalFlow = ApprovalFlow::where('model_type', 'App\Models\PengajuanInvoice')->first();
        $approvalSteps = ApprovalStep::where('approval_flow_id', $checkApprovalFlow->id)->orderBy('step', 'asc')->get();
        foreach ($approvalSteps as $key => $value) {
            if ($value->step == 1) {
                if ($value->type_of_agreement == 'Pemeriksa') {
                    $pengajuanInvoice->update([
                        'status' => 'Pemeriksaan'
                    ]);
                } elseif ($value->type_of_agreement == 'Pemberi Persetujuan') {
                    $pengajuanInvoice->update([
                        'status' => 'Persetujuan'
                    ]);
                }
            }
            $status = ($value->step == 1) ? 1 : 0;
            $checkEmployee = Structure::where('area_id', $value->area_id)->where('position_id', $value->position_id)->first();
            $pengajuanInvoice->approvalHistories()->create([
                'approval_flow_id' => $checkApprovalFlow->id,
                'approval_step_id' => $value->id,
                'approved_by' => $checkEmployee->employee_id,
                'status' => $status
            ]);
        }
    }

    /**
     * Handle the PengajuanInvoice "updated" event.
     */
    public function updated(PengajuanInvoice $pengajuanInvoice): void
    {
        //
    }

    /**
     * Handle the PengajuanInvoice "deleted" event.
     */
    public function deleted(PengajuanInvoice $pengajuanInvoice): void
    {
        //
    }

    /**
     * Handle the PengajuanInvoice "restored" event.
     */
    public function restored(PengajuanInvoice $pengajuanInvoice): void
    {
        //
    }

    /**
     * Handle the PengajuanInvoice "force deleted" event.
     */
    public function forceDeleted(PengajuanInvoice $pengajuanInvoice): void
    {
        //
    }
}
