<?php

namespace App\Policies;

use App\Models\Absensi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AbsensiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('absensi: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Absensi $absensi): bool
    {
        return $user->hasPermissionTo('absensi: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('absensi: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Absensi $absensi): bool
    {
        return $user->hasPermissionTo('absensi: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Absensi $absensi): bool
    {
        return $user->hasPermissionTo('absensi: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Absensi $absensi): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Absensi $absensi): bool
    {
        return false;
    }
}
