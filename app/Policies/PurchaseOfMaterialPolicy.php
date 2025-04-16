<?php

namespace App\Policies;

use App\Models\PurchaseOfMaterial;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PurchaseOfMaterialPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('pembelian-material: menu') || $user->hasPermissionTo('laporan-pembelian-material: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PurchaseOfMaterial $purchaseOfMaterial): bool
    {
        return $user->hasPermissionTo('pembelian-material: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('pembelian-material: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PurchaseOfMaterial $purchaseOfMaterial): bool
    {
        return $user->hasPermissionTo('pembelian-material: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PurchaseOfMaterial $purchaseOfMaterial): bool
    {
        return $user->hasPermissionTo('pembelian-material: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PurchaseOfMaterial $purchaseOfMaterial): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PurchaseOfMaterial $purchaseOfMaterial): bool
    {
        return false;
    }
}
