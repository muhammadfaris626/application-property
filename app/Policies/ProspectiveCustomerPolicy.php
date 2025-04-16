<?php

namespace App\Policies;

use App\Models\ProspectiveCustomer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProspectiveCustomerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('calon-user: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProspectiveCustomer $prospectiveCustomer): bool
    {
        return $user->hasPermissionTo('calon-user: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('calon-user: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProspectiveCustomer $prospectiveCustomer): bool
    {
        return $user->hasPermissionTo('calon-user: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProspectiveCustomer $prospectiveCustomer): bool
    {
        return $user->hasPermissionTo('calon-user: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProspectiveCustomer $prospectiveCustomer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProspectiveCustomer $prospectiveCustomer): bool
    {
        return false;
    }
}
