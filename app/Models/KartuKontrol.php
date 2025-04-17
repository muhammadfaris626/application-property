<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KartuKontrol extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'customer_id', 'sbum', 'dp', 'imb', 'sertifikat', 'jkk', 'listrik', 'bestek', 'employee_id', 'area_id'];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function area(): BelongsTo {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
