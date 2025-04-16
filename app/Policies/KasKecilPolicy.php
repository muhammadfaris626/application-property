<?php

namespace App\Policies;

use App\Models\KasKecil;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KasKecilPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('pemasukan-kas-kecil: menu') || $user->hasPermissionTo('pengeluaran-kas-kecil: menu') || $user->hasPermissionTo('laporan-kas-kecil: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, KasKecil $kasKecil): bool
    {
        return $user->hasPermissionTo('pemasukan-kas-kecil: read') || $user->hasPermissionTo('pengeluaran-kas-kecil: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('pemasukan-kas-kecil: create') || $user->hasPermissionTo('pengeluaran-kas-kecil: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, KasKecil $kasKecil): bool
    {
        return $user->hasPermissionTo('pemasukan-kas-kecil: update') || $user->hasPermissionTo('pengeluaran-kas-kecil: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KasKecil $kasKecil): bool
    {
        return $user->hasPermissionTo('pemasukan-kas-kecil: delete') || $user->hasPermissionTo('pengeluaran-kas-kecil: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, KasKecil $kasKecil): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, KasKecil $kasKecil): bool
    {
        return false;
    }
}
