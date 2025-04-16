<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KasKecil extends Model
{
    /** @use HasFactory<\Database\Factories\KasKecilFactory> */
    use HasFactory;

    protected $fillable = ['category', 'date', 'employee_id', 'area_id'];

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function area(): BelongsTo {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function listKasKecils(): HasMany {
        return $this->hasMany(ListKasKecil::class);
    }
}
