<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProspectiveCustomer extends Model
{
    /** @use HasFactory<\Database\Factories\ProspectiveCustomerFactory> */
    use HasFactory;

    protected $fillable = ['date', 'identification_number', 'name', 'address', 'whatsapp_number', 'email', 'employee_id', 'area_id'];

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function area(): BelongsTo {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function customers(): HasMany {
        return $this->hasMany(Customer::class);
    }
}
