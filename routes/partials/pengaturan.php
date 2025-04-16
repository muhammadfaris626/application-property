<?php

use App\Livewire\Pengaturan\Akun\CreateAkun;
use App\Livewire\Pengaturan\Akun\EditAkun;
use App\Livewire\Pengaturan\Akun\IndexAkun;
use App\Livewire\Pengaturan\Akun\ShowAkun;
use App\Livewire\Pengaturan\Peran\CreatePeran;
use App\Livewire\Pengaturan\Peran\EditPeran;
use App\Livewire\Pengaturan\Peran\IndexPeran;
use App\Livewire\Pengaturan\Peran\PeranPerizinan\CreatePeranPerizinan;
use App\Livewire\Pengaturan\Peran\ShowPeran;
use App\Livewire\Pengaturan\Perizinan\CreatePerizinan;
use App\Livewire\Pengaturan\Perizinan\EditPerizinan;
use App\Livewire\Pengaturan\Perizinan\IndexPerizinan;
use App\Livewire\Pengaturan\Perizinan\ShowPerizinan;
use App\Livewire\Pengaturan\Persetujuan\ApprovalStep\CreateApprovalStep;
use App\Livewire\Pengaturan\Persetujuan\ApprovalStep\EditApprovalStep;
use App\Livewire\Pengaturan\Persetujuan\CreatePersetujuan;
use App\Livewire\Pengaturan\Persetujuan\EditPersetujuan;
use App\Livewire\Pengaturan\Persetujuan\IndexPersetujuan;
use App\Livewire\Pengaturan\Persetujuan\ShowPersetujuan;
use Illuminate\Support\Facades\Route;

Route::prefix('pengaturan')->group(function() {
    Route::prefix('persetujuan')->name('persetujuan.')->group(function() {
        Route::get('/', IndexPersetujuan::class)->name('index');
        Route::get('/create', CreatePersetujuan::class)->name('create');
        Route::get('/show/{id}', ShowPersetujuan::class)->name('show');
        Route::get('/edit/{id}', EditPersetujuan::class)->name('edit');
        Route::delete('/{id}', [IndexPersetujuan::class, 'destroy'])->name('destroy');
    });

    Route::prefix('persetujuan/langkah-persetujuan')->name('langkah-persetujuan.')->group(function() {
        Route::get('/create/{id}', CreateApprovalStep::class)->name('create');
        Route::get('/edit/{id}', EditApprovalStep::class)->name('edit');
        Route::delete('/{id}', [ShowPersetujuan::class, 'destroy'])->name('destroy');
    });

    Route::prefix('akun')->name('akun.')->group(function() {
        Route::get('/', IndexAkun::class)->name('index');
        Route::get('/create', CreateAkun::class)->name('create');
        Route::get('/show/{id}', ShowAkun::class)->name('show');
        Route::get('/edit/{id}', EditAkun::class)->name('edit');
        Route::delete('/{id}', [IndexAkun::class, 'destroy'])->name('destroy');
    });

    Route::prefix('peran')->name('peran.')->group(function() {
        Route::get('/', IndexPeran::class)->name('index');
        Route::get('/create', CreatePeran::class)->name('create');
        Route::get('/show/{id}', ShowPeran::class)->name('show');
        Route::get('/edit/{id}', EditPeran::class)->name('edit');
        Route::delete('/{id}', [IndexPeran::class, 'destroy'])->name('destroy');
    });

    Route::prefix('peran/peran-perizinan')->name('peran-perizinan.')->group(function() {
        Route::get('/create/{id}', CreatePeranPerizinan::class)->name('create');
    });

    Route::prefix('perizinan')->name('perizinan.')->group(function() {
        Route::get('/', IndexPerizinan::class)->name('index');
        Route::get('/create', CreatePerizinan::class)->name('create');
        Route::get('/show/{id}', ShowPerizinan::class)->name('show');
        Route::get('/edit/{id}', EditPerizinan::class)->name('edit');
        Route::delete('/{id}', [IndexPerizinan::class, 'destroy'])->name('destroy');
    });
});
