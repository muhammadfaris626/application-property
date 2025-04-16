<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOfMaterial extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseOfMaterialFactory> */
    use HasFactory;

    protected $fillable = ['invoice_number', 'date', 'supplier_id', 'employee_id'];

    public function supplier(): BelongsTo {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function listPurchaseOfMaterials(): HasMany {
        return $this->hasMany(ListPurchaseOfMaterial::class);
    }
}
