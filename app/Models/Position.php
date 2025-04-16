<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    /** @use HasFactory<\Database\Factories\PositionFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    public function structures(): HasMany {
        return $this->hasMany(Structure::class);
    }

    public function approvalSteps(): HasMany {
        return $this->hasMany(ApprovalStep::class);
    }
}
