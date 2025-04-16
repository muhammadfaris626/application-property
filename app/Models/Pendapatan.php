<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendapatan extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'type_of_income_id', 'customer_id', 'keterangan', 'total', 'employee_id'];

    public function typeOfIncome(): BelongsTo {
        return $this->belongsTo(TypeOfIncome::class, 'type_of_income_id');
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
