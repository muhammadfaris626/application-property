<?php

namespace App\Policies;

use App\Models\Structure;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StructurePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('struktur: menu') || $user->hasPermissionTo('kinerja: menu') || $user->hasPermissionTo('profil: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Structure $structure): bool
    {
        return $user->hasPermissionTo('struktur: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('struktur: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Structure $structure): bool
    {
        return $user->hasPermissionTo('struktur: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Structure $structure): bool
    {
        return $user->hasPermissionTo('struktur: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Structure $structure): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Structure $structure): bool
    {
        return false;
    }
}
