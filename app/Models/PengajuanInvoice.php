<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PengajuanInvoice extends Model
{
    /** @use HasFactory<\Database\Factories\PengajuanInvoiceFactory> */
    use HasFactory;

    protected $fillable = ['date', 'employee_id', 'price', 'desc', 'approved_price'];

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function approvalHistories(): MorphMany {
        return $this->morphMany(ApprovalHistory::class, 'approvable');
    }

}
