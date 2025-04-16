<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApprovalFlow extends Model
{
    /** @use HasFactory<\Database\Factories\ApprovalFlowFactory> */
    use HasFactory;

    protected $fillable = ['name', 'model_type'];

    public function approvalSteps(): HasMany {
        return $this->hasMany(ApprovalStep::class);
    }

    public function approvalHistories(): HasMany {
        return $this->hasMany(ApprovalHistory::class);
    }
}
