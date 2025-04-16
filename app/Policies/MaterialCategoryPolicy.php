<?php

namespace App\Policies;

use App\Models\MaterialCategory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MaterialCategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('material-kategori: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MaterialCategory $materialCategory): bool
    {
        return $user->hasPermissionTo('material-kategori: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('material-kategori: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MaterialCategory $materialCategory): bool
    {
        return $user->hasPermissionTo('material-kategori: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MaterialCategory $materialCategory): bool
    {
        return $user->hasPermissionTo('material-kategori: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MaterialCategory $materialCategory): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MaterialCategory $materialCategory): bool
    {
        return false;
    }
}
