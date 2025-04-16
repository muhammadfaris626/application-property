<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListPurchaseOfMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['purchase_of_material_id', 'material_id', 'quantity', 'price', 'total_price'];

    public function purchaseOfMaterial(): BelongsTo {
        return $this->belongsTo(PurchaseOfMaterial::class, 'purchase_of_material_id');
    }

    public function material(): BelongsTo {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
