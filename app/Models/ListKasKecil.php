<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListKasKecil extends Model
{
    use HasFactory;

    protected $fillable = ['kas_kecil_id', 'type_of_income_id', 'type_of_expenditure_id', 'desc', 'total'];

    public function kasKecil(): BelongsTo {
        return $this->belongsTo(KasKecil::class, 'kas_kecil_id');
    }

    public function typeOfIncome(): BelongsTo {
        return $this->belongsTo(TypeOfIncome::class, 'type_of_income_id');
    }

    public function typeOfExpenditure(): BelongsTo {
        return $this->belongsTo(TypeOfExpenditure::class, 'type_of_expenditure_id');
    }
}
