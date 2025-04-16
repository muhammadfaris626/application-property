<?php

namespace App\Policies;

use App\Models\PermintaanMaterial;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermintaanMaterialPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('permintaan-material: menu') || $user->hasPermissionTo('laporan-permintaan-material: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PermintaanMaterial $permintaanMaterial): bool
    {
        return $user->hasPermissionTo('permintaan-material: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('permintaan-material: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PermintaanMaterial $permintaanMaterial): bool
    {
        return $user->hasPermissionTo('permintaan-material: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PermintaanMaterial $permintaanMaterial): bool
    {
        return $user->hasPermissionTo('permintaan-material: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PermintaanMaterial $permintaanMaterial): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PermintaanMaterial $permintaanMaterial): bool
    {
        return false;
    }
}
