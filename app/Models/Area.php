<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address'];

    public function typeOfHouses(): HasMany {
        return $this->hasMany(TypeOfHouse::class);
    }

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }

    public function structures(): HasMany {
        return $this->hasMany(Structure::class);
    }

    public function mutations(): HasMany {
        return $this->hasMany(Mutation::class);
    }

    public function prospectiveCustomers(): HasMany {
        return $this->hasMany(ProspectiveCustomer::class);
    }

    public function kasKecils(): HasMany {
        return $this->hasMany(KasKecil::class);
    }

    public function approvalSteps(): HasMany {
        return $this->hasMany(ApprovalStep::class);
    }

    public function permintaanMaterials(): HasMany {
        return $this->hasMany(PermintaanMaterial::class);
    }

    public function customers(): HasMany {
        return $this->hasMany(Customer::class);
    }

    public function kartuKontrols(): HasMany {
        return $this->hasMany(KartuKontrol::class);
    }

    public function pendapatans(): HasMany {
        return $this->hasMany(Pendapatan::class);
    }

    public function pengajuanInvoices(): HasMany {
        return $this->hasMany(PengajuanInvoice::class);
    }
}
