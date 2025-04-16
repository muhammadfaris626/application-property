<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListPermintaanMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['permintaan_material_id', 'material_id', 'quantity', 'approved_quantity'];

    public function permintaanMaterial(): BelongsTo {
        return $this->belongsTo(PermintaanMaterial::class, 'permintaan_material_id');
    }

    public function material(): BelongsTo {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
