<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApprovalStep extends Model
{
    /** @use HasFactory<\Database\Factories\ApprovalStepFactory> */
    use HasFactory;

    protected $fillable = ['approval_flow_id', 'step', 'area_id', 'position_id', 'type_of_agreement'];

    public function approvalFlow(): BelongsTo {
        return $this->belongsTo(ApprovalFlow::class, 'approval_flow_id');
    }

    public function area(): BelongsTo {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function position(): BelongsTo {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function approvalHistories(): HasMany {
        return $this->hasMany(ApprovalHistory::class);
    }
}
