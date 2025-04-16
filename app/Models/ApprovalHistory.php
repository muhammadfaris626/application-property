<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalHistory extends Model
{
    use HasFactory;

    protected $fillable = ['approval_flow_id', 'approvable_id', 'approvable_type', 'approval_step_id', 'desc', 'marker', 'approved_by', 'status'];

    public function approvalFlow(): BelongsTo {
        return $this->belongsTo(ApprovalFlow::class, 'approval_flow_id');
    }

    public function approvable() {
        return $this->morphTo();
    }

    public function approvalStep(): BelongsTo {
        return $this->belongsTo(ApprovalStep::class, 'approval_step_id');
    }

    public function approvedBy(): BelongsTo {
        return $this->belongsTo(Employee::class, 'approved_by');
    }
}
