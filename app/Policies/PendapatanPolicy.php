<?php

namespace App\Policies;

use App\Models\Pendapatan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PendapatanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('pemasukan-pendapatan: menu') || $user->hasPermissionTo('laporan-pendapatan: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pendapatan $pendapatan): bool
    {
        return $user->hasPermissionTo('pemasukan-pendapatan: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('pemasukan-pendapatan: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pendapatan $pendapatan): bool
    {
        return $user->hasPermissionTo('pemasukan-pendapatan: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pendapatan $pendapatan): bool
    {
        return $user->hasPermissionTo('pemasukan-pendapatan: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pendapatan $pendapatan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pendapatan $pendapatan): bool
    {
        return false;
    }
}
