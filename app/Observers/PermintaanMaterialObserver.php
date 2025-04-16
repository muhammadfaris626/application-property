<?php

namespace App\Observers;

use App\Models\ApprovalFlow;
use App\Models\ApprovalStep;
use App\Models\PermintaanMaterial;
use App\Models\Structure;

class PermintaanMaterialObserver
{
    /**
     * Handle the PermintaanMaterial "created" event.
     */
    public function created(PermintaanMaterial $permintaanMaterial): void
    {
        $checkApprovalFLow = ApprovalFlow::where('model_type', 'App\Models\PermintaanMaterial')->first();
        $approvalSteps = ApprovalStep::where('approval_flow_id', $checkApprovalFLow->id)->orderBy('step', 'asc')->get();
        foreach ($approvalSteps as $key => $value) {
            $status = ($value->step == 1) ? 1 : 0;
            $checkEmployee = Structure::where('area_id', $value->area_id)->where('position_id', $value->position_id)->first();
            $permintaanMaterial->approvalHistories()->create([
                'approval_flow_id' => $checkApprovalFLow->id,
                'approval_step_id' => $value->id,
                'approved_by' => $checkEmployee->employee_id,
                'status' => $status
            ]);
        }
    }

    /**
     * Handle the PermintaanMaterial "updated" event.
     */
    public function updated(PermintaanMaterial $permintaanMaterial): void
    {
        //
    }

    /**
     * Handle the PermintaanMaterial "deleted" event.
     */
    public function deleted(PermintaanMaterial $permintaanMaterial): void
    {
        //
    }

    /**
     * Handle the PermintaanMaterial "restored" event.
     */
    public function restored(PermintaanMaterial $permintaanMaterial): void
    {
        //
    }

    /**
     * Handle the PermintaanMaterial "force deleted" event.
     */
    public function forceDeleted(PermintaanMaterial $permintaanMaterial): void
    {
        //
    }
}
