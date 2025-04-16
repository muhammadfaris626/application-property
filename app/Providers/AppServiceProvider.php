<?php

namespace App\Providers;

use App\Models\PengajuanInvoice;
use App\Models\PermintaanMaterial;
use App\Observers\PengajuanInvoiceObserver;
use App\Observers\PermintaanMaterialObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PermintaanMaterial::observe(PermintaanMaterialObserver::class);
        PengajuanInvoice::observe(PengajuanInvoiceObserver::class);
    }
}
