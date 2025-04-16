<?php

namespace App\Policies;

use App\Models\TypeOfExpenditure;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TypeOfExpenditurePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('jenis-pengeluaran: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TypeOfExpenditure $typeOfExpenditure): bool
    {
        return $user->hasPermissionTo('jenis-pengeluaran: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('jenis-pengeluaran: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TypeOfExpenditure $typeOfExpenditure): bool
    {
        return $user->hasPermissionTo('jenis-pengeluaran: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TypeOfExpenditure $typeOfExpenditure): bool
    {
        return $user->hasPermissionTo('jenis-pengeluaran: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TypeOfExpenditure $typeOfExpenditure): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TypeOfExpenditure $typeOfExpenditure): bool
    {
        return false;
    }
}
