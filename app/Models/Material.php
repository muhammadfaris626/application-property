<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
    use HasFactory;

    protected $fillable = ['material_category_id', 'name'];

    public function materialCategory(): BelongsTo {
        return $this->belongsTo(MaterialCategory::class, 'material_category_id');
    }

    public function listPurchaseOfMaterials(): HasMany {
        return $this->hasMany(ListPurchaseOfMaterial::class);
    }

    public function listPermintaanMaterials(): HasMany {
        return $this->hasMany(ListPermintaanMaterial::class);
    }
}
