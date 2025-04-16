<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KartuKontrol extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'customer_id', 'sbum', 'dp', 'imb', 'sertifikat', 'jkk', 'listrik', 'bestek'];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
