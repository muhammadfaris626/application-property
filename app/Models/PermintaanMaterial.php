<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PermintaanMaterial extends Model
{
    /** @use HasFactory<\Database\Factories\PermintaanMaterialFactory> */
    use HasFactory;

    protected $fillable = ['date', 'ro_number', 'employee_id', 'area_id'];

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function area(): BelongsTo {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function listPermintaanMaterials(): HasMany {
        return $this->hasMany(ListPermintaanMaterial::class);
    }

    public function approvalHistories(): MorphMany {
        return $this->morphMany(ApprovalHistory::class, 'approvable');
    }
}
