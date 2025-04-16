<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Structure extends Model
{
    /** @use HasFactory<\Database\Factories\StructureFactory> */
    use HasFactory;

    protected $fillable = ['employee_id', 'position_id', 'area_id', 'employee_number'];

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function position(): BelongsTo {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function area(): BelongsTo {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
