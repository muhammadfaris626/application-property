<?php

use App\Livewire\Penjualan\CalonUser\CreateCalonUser;
use App\Livewire\Penjualan\CalonUser\EditCalonUser;
use App\Livewire\Penjualan\CalonUser\IndexCalonUser;
use App\Livewire\Penjualan\CalonUser\ShowCalonUser;
use App\Livewire\Penjualan\KartuKontrol\CreateKartuKontrol;
use App\Livewire\Penjualan\KartuKontrol\EditKartuKontrol;
use App\Livewire\Penjualan\KartuKontrol\IndexKartuKontrol;
use App\Livewire\Penjualan\KartuKontrol\ShowKartuKontrol;
use App\Livewire\Penjualan\User\CreateUser;
use App\Livewire\Penjualan\User\EditUser;
use App\Livewire\Penjualan\User\IndexUser;
use App\Livewire\Penjualan\User\ShowUser;
use Illuminate\Support\Facades\Route;

Route::prefix('produk/penjualan')->group(function() {
    // Calon User
    Route::prefix('calon-user')->name('calon-user.')->group(function() {
        Route::get('/', IndexCalonUser::class)->name('index');
        Route::get('/create', CreateCalonUser::class)->name('create');
        Route::get('/show/{id}', ShowCalonUser::class)->name('show');
        Route::get('/edit/{id}', EditCalonUser::class)->name('edit');
        Route::delete('/{id}', [IndexCalonUser::class, 'destroy'])->name('destroy');
    });
    // User
    Route::prefix('customer')->name('customer.')->group(function() {
        Route::get('/', IndexUser::class)->name('index');
        Route::get('/create', CreateUser::class)->name('create');
        Route::get('/show/{id}', ShowUser::class)->name('show');
        Route::get('/edit/{id}', EditUser::class)->name('edit');
        Route::delete('/{id}', [IndexUser::class, 'destroy'])->name('destroy');
    });
    // Kartu Kontrol
    Route::prefix('kartu-kontrol')->name('kartu-kontrol.')->group(function() {
        Route::get('/', IndexKartuKontrol::class)->name('index');
        Route::get('/create', CreateKartuKontrol::class)->name('create');
        Route::get('/show/{id}', ShowKartuKontrol::class)->name('show');
        Route::get('/edit/{id}', EditKartuKontrol::class)->name('edit');
        Route::delete('/{id}', [IndexKartuKontrol::class, 'destroy'])->name('destroy');
    });
});
