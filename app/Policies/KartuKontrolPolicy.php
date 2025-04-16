<?php

namespace App\Policies;

use App\Models\KartuKontrol;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KartuKontrolPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('kartu-kontrol: menu') || $user->hasPermissionTo('laporan-data-jaminan-user: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, KartuKontrol $kartuKontrol): bool
    {
        return $user->hasPermissionTo('kartu-kontrol: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('kartu-kontrol: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, KartuKontrol $kartuKontrol): bool
    {
        return $user->hasPermissionTo('kartu-kontrol: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KartuKontrol $kartuKontrol): bool
    {
        return $user->hasPermissionTo('kartu-kontrol: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, KartuKontrol $kartuKontrol): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, KartuKontrol $kartuKontrol): bool
    {
        return false;
    }
}
