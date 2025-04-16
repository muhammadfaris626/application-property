<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeOfHouse extends Model
{
    /** @use HasFactory<\Database\Factories\TypeOfHouseFactory> */
    use HasFactory;

    protected $fillable = ['area_id', 'code', 'name', 'price'];

    public function area(): BelongsTo {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function customers(): HasMany {
        return $this->hasMany(Customer::class);
    }
}
