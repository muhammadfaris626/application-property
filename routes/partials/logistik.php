<?php

use App\Livewire\PembelianMaterial\CreatePembelianMaterial;
use App\Livewire\PembelianMaterial\EditPembelianMaterial;
use App\Livewire\PembelianMaterial\IndexPembelianMaterial;
use App\Livewire\PembelianMaterial\ShowPembelianMaterial;
use App\Livewire\PermintaanMaterial\ApprovalPermintaanMaterial;
use App\Livewire\PermintaanMaterial\CreatePermintaanMaterial;
use App\Livewire\PermintaanMaterial\EditPermintaanMaterial;
use App\Livewire\PermintaanMaterial\IndexPermintaanMaterial;
use App\Livewire\PermintaanMaterial\ShowPermintaanMaterial;
use Illuminate\Support\Facades\Route;

Route::prefix('logistik')->group(function() {
    // Pembelian Material
    Route::prefix('pembelian-material')->name('pembelian-material.')->group(function() {
        Route::get('/', IndexPembelianMaterial::class)->name('index');
        Route::get('/create', CreatePembelianMaterial::class)->name('create');
        Route::get('/show/{id}', ShowPembelianMaterial::class)->name('show');
        Route::get('/edit/{id}', EditPembelianMaterial::class)->name('edit');
        Route::delete('/{id}', [IndexPembelianMaterial::class, 'destroy'])->name('destroy');
    });

    Route::prefix('permintaan-material')->name('permintaan-material.')->group(function() {
        Route::get('/', IndexPermintaanMaterial::class)->name('index');
        Route::get('/create', CreatePermintaanMaterial::class)->name('create');
        Route::get('/show/{id}', ShowPermintaanMaterial::class)->name('show');
        Route::get('/edit/{id}', EditPermintaanMaterial::class)->name('edit');
        Route::delete('/{id}', [IndexPermintaanMaterial::class, 'destroy'])->name('destroy');
        Route::get('/approval/{id}', ApprovalPermintaanMaterial::class)->name('approval');
    });
});
