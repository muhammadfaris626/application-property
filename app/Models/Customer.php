<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = ['tanggal', 'nomor_berkas', 'prospective_customer_id', 'type_of_house_id', 'keterangan_rumah', 'status_penjualan', 'status_pengajuan_user', 'verifikasi_dp', 'upload_berkas', 'employee_id'];

    public function prospectiveCustomer(): BelongsTo {
        return $this->belongsTo(ProspectiveCustomer::class, 'prospective_customer_id');
    }

    public function typeOfHouse(): BelongsTo {
        return $this->belongsTo(TypeOfHouse::class, 'type_of_house_id');
    }

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function kartuKontrols(): HasMany {
        return $this->hasMany(KartuKontrol::class);
    }

    public function pendapatans(): HasMany {
        return $this->hasMany(Pendapatan::class);
    }
}
