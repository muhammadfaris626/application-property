<?php

namespace App\Policies;

use App\Models\Mutation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MutationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('mutasi: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Mutation $mutation): bool
    {
        return $user->hasPermissionTo('mutasi: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('mutasi: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Mutation $mutation): bool
    {
        return $user->hasPermissionTo('mutasi: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Mutation $mutation): bool
    {
        return $user->hasPermissionTo('mutasi: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Mutation $mutation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Mutation $mutation): bool
    {
        return false;
    }
}
