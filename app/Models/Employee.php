<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $fillable = ['identification_number', 'name', 'address', 'place_of_birth', 'date_of_birth', 'whatsapp_number', 'email', 'active'];

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }

    public function structures(): HasMany {
        return $this->hasMany(Structure::class);
    }

    public function mutations(): HasMany {
        return $this->hasMany(Mutation::class);
    }

    public function terminations(): HasMany {
        return $this->hasMany(Termination::class);
    }

    public function prospectiveCustomers(): HasMany {
        return $this->hasMany(ProspectiveCustomer::class);
    }

    public function purchaseOfMaterials(): HasMany {
        return $this->hasMany(PurchaseOfMaterial::class);
    }

    public function kasBesars(): HasMany {
        return $this->hasMany(KasBesar::class);
    }

    public function kasKecils(): HasMany {
        return $this->hasMany(KasKecil::class);
    }

    public function pengajuanInvoices(): HasMany {
        return $this->hasMany(PengajuanInvoice::class);
    }

    public function permintaanMaterials(): HasMany {
        return $this->hasMany(PermintaanMaterial::class);
    }

    public function approvalHistories(): HasMany {
        return $this->hasMany(ApprovalHistory::class);
    }

    public function absensis(): HasMany {
        return $this->hasMany(Absensi::class);
    }

    public function customers(): HasMany {
        return $this->hasMany(Customer::class);
    }

    public function pendapatans(): HasMany {
        return $this->hasMany(Pendapatan::class);
    }

    public function kartuKontrols(): HasMany {
        return $this->hasMany(KartuKontrol::class);
    }
}
