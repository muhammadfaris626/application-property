<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeOfIncome extends Model
{
    /** @use HasFactory<\Database\Factories\TypeOfIncomeFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    public function listKasBesars(): HasMany {
        return $this->hasMany(ListKasBesar::class);
    }

    public function listKasKecils(): HasMany {
        return $this->hasMany(ListKasKecil::class);
    }

    public function pendapatans(): HasMany {
        return $this->hasMany(Pendapatan::class);
    }
}
