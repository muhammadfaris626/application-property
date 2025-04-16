<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Termination extends Model
{
    /** @use HasFactory<\Database\Factories\TerminationFactory> */
    use HasFactory;

    protected $fillable = ['date', 'employee_id'];

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
