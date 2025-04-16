<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KasBesar extends Model
{
    /** @use HasFactory<\Database\Factories\KasBesarFactory> */
    use HasFactory;

    protected $fillable = ['category', 'date', 'employee_id'];

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function listKasBesars(): HasMany {
        return $this->hasMany(ListKasBesar::class);
    }
}
