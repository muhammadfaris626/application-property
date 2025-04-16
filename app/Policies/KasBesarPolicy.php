<?php

namespace App\Policies;

use App\Models\KasBesar;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KasBesarPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('pemasukan-kas-besar: menu') || $user->hasPermissionTo('pengeluaran-kas-besar: menu') || $user->hasPermissionTo('laporan-kas-besar: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, KasBesar $kasBesar): bool
    {
        return $user->hasPermissionTo('pemasukan-kas-besar: read') || $user->hasPermissionTo('pengeluaran-kas-besar: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('pemasukan-kas-besar: create') || $user->hasPermissionTo('pengeluaran-kas-besar: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, KasBesar $kasBesar): bool
    {
        return $user->hasPermissionTo('pemasukan-kas-besar: update') || $user->hasPermissionTo('pengeluaran-kas-besar: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KasBesar $kasBesar): bool
    {
        return $user->hasPermissionTo('pemasukan-kas-besar: delete') || $user->hasPermissionTo('pengeluaran-kas-besar: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, KasBesar $kasBesar): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, KasBesar $kasBesar): bool
    {
        return false;
    }
}
