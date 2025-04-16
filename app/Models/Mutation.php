<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mutation extends Model
{
    /** @use HasFactory<\Database\Factories\MutationFactory> */
    use HasFactory;

    protected $fillable = ['date', 'employee_id', 'from_area_id', 'to_area_id'];

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function fromArea(): BelongsTo {
        return $this->belongsTo(Area::class, 'from_area_id');
    }

    public function toArea(): BelongsTo {
        return $this->belongsTo(Area::class, 'to_area_id');
    }
}
