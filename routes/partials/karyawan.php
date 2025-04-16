<?php

use App\Livewire\Karyawan\Absensi\CreateAbsensi;
use App\Livewire\Karyawan\Absensi\EditAbsensi;
use App\Livewire\Karyawan\Absensi\IndexAbsensi;
use App\Livewire\Karyawan\Absensi\ShowAbsensi;
use App\Livewire\Karyawan\Kinerja\CreateKinerja;
use App\Livewire\Karyawan\Kinerja\EditKinerja;
use App\Livewire\Karyawan\Kinerja\IndexKinerja;
use App\Livewire\Karyawan\Kinerja\ShowKinerja;
use App\Livewire\Karyawan\Mutasi\CreateMutasi;
use App\Livewire\Karyawan\Mutasi\EditMutasi;
use App\Livewire\Karyawan\Mutasi\IndexMutasi;
use App\Livewire\Karyawan\Mutasi\ShowMutasi;
use App\Livewire\Karyawan\Pemberhentian\CreatePemberhentian;
use App\Livewire\Karyawan\Pemberhentian\EditPemberhentian;
use App\Livewire\Karyawan\Pemberhentian\IndexPemberhentian;
use App\Livewire\Karyawan\Pemberhentian\ShowPemberhentian;
use App\Livewire\Karyawan\Profil\CreateProfil;
use App\Livewire\Karyawan\Profil\EditProfil;
use App\Livewire\Karyawan\Profil\IndexProfil;
use App\Livewire\Karyawan\Profil\ShowProfil;
use App\Livewire\Struktur\CreateStruktur;
use App\Livewire\Struktur\EditStruktur;
use App\Livewire\Struktur\IndexStruktur;
use App\Livewire\Struktur\ShowStruktur;
use Illuminate\Support\Facades\Route;

Route::prefix('karyawan')->group(function() {
    Route::prefix('absensi')->name('absensi.')->group(function() {
        Route::get('/', IndexAbsensi::class)->name('index');
        Route::get('/create', CreateAbsensi::class)->name('create');
        Route::get('/show/{id}', ShowAbsensi::class)->name('show');
        Route::get('/edit/{id}', EditAbsensi::class)->name('edit');
        Route::delete('/{id}', [IndexAbsensi::class, 'destroy'])->name('destroy');
    });
    Route::prefix('mutasi')->name('mutasi.')->group(function() {
        Route::get('/', IndexMutasi::class)->name('index');
        Route::get('/create', CreateMutasi::class)->name('create');
        Route::get('/show/{id}', ShowMutasi::class)->name('show');
        Route::get('/edit/{id}', EditMutasi::class)->name('edit');
        Route::delete('/{id}', [IndexMutasi::class, 'destroy'])->name('destroy');
    });
    Route::prefix('pemberhentian')->name('pemberhentian.')->group(function() {
        Route::get('/', IndexPemberhentian::class)->name('index');
        Route::get('/create', CreatePemberhentian::class)->name('create');
        Route::get('/show/{id}', ShowPemberhentian::class)->name('show');
        Route::get('/edit/{id}', EditPemberhentian::class)->name('edit');
        Route::delete('/{id}', [IndexPemberhentian::class, 'destroy'])->name('destroy');
    });
    Route::prefix('profil')->name('profil.')->group(function() {
        Route::get('/', IndexProfil::class)->name('index');
        Route::get('/create', CreateProfil::class)->name('create');
        Route::get('/show/{id}', ShowProfil::class)->name('show');
        Route::get('/edit/{id}', EditProfil::class)->name('edit');
        Route::delete('/{id}', [IndexProfil::class, 'destroy'])->name('destroy');
    });
    Route::prefix('kinerja')->name('kinerja.')->group(function() {
        Route::get('/', IndexKinerja::class)->name('index');
        Route::get('/create', CreateKinerja::class)->name('create');
        Route::get('/show/{id}', ShowKinerja::class)->name('show');
        Route::get('/edit/{id}', EditKinerja::class)->name('edit');
        Route::delete('/{id}', [IndexKinerja::class, 'destroy'])->name('destroy');
    });
});

Route::prefix('struktur')->name('struktur.')->group(function() {
    Route::get('/', IndexStruktur::class)->name('index');
    Route::get('/create', CreateStruktur::class)->name('create');
    Route::get('/show/{id}', ShowStruktur::class)->name('show');
    Route::get('/edit/{id}', EditStruktur::class)->name('edit');
    Route::delete('/{id}', [IndexStruktur::class, 'destroy'])->name('destroy');
});

