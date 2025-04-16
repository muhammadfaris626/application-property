<?php

namespace App\Policies;

use App\Models\TypeOfHouse;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TypeOfHousePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('jenis-rumah: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TypeOfHouse $typeOfHouse): bool
    {
        return $user->hasPermissionTo('jenis-rumah: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('jenis-rumah: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TypeOfHouse $typeOfHouse): bool
    {
        return $user->hasPermissionTo('jenis-rumah: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TypeOfHouse $typeOfHouse): bool
    {
        return $user->hasPermissionTo('jenis-rumah: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TypeOfHouse $typeOfHouse): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TypeOfHouse $typeOfHouse): bool
    {
        return false;
    }
}
