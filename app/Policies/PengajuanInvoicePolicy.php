<?php

namespace App\Policies;

use App\Models\PengajuanInvoice;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PengajuanInvoicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('pengajuan-invoice: menu') || $user->hasPermissionTo('laporan-pengajuan-invoice: menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PengajuanInvoice $pengajuanInvoice): bool
    {
        return $user->hasPermissionTo('pengajuan-invoice: read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('pengajuan-invoice: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PengajuanInvoice $pengajuanInvoice): bool
    {
        return $user->hasPermissionTo('pengajuan-invoice: update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PengajuanInvoice $pengajuanInvoice): bool
    {
        return $user->hasPermissionTo('pengajuan-invoice: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PengajuanInvoice $pengajuanInvoice): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PengajuanInvoice $pengajuanInvoice): bool
    {
        return false;
    }
}
