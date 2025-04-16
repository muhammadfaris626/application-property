<?php

use App\Livewire\Database\Area\CreateArea;
use App\Livewire\Database\Area\EditArea;
use App\Livewire\Database\Area\IndexArea;
use App\Livewire\Database\Area\ShowArea;
use App\Livewire\Database\Jabatan\CreateJabatan;
use App\Livewire\Database\Jabatan\EditJabatan;
use App\Livewire\Database\Jabatan\IndexJabatan;
use App\Livewire\Database\Jabatan\ShowJabatan;
use App\Livewire\Database\JenisPemasukan\CreateJenisPemasukan;
use App\Livewire\Database\JenisPemasukan\EditJenisPemasukan;
use App\Livewire\Database\JenisPemasukan\IndexJenisPemasukan;
use App\Livewire\Database\JenisPemasukan\ShowJenisPemasukan;
use App\Livewire\Database\JenisPengeluaran\CreateJenisPengeluaran;
use App\Livewire\Database\JenisPengeluaran\EditJenisPengeluaran;
use App\Livewire\Database\JenisPengeluaran\IndexJenisPengeluaran;
use App\Livewire\Database\JenisPengeluaran\ShowJenisPengeluaran;
use App\Livewire\Database\JenisRumah\CreateJenisRumah;
use App\Livewire\Database\JenisRumah\EditJenisRumah;
use App\Livewire\Database\JenisRumah\IndexJenisRumah;
use App\Livewire\Database\JenisRumah\ShowJenisRumah;
use App\Livewire\Database\Karyawan\CreateKaryawan;
use App\Livewire\Database\Karyawan\EditKaryawan;
use App\Livewire\Database\Karyawan\IndexKaryawan;
use App\Livewire\Database\Karyawan\ShowKaryawan;
use App\Livewire\Database\Material\CreateMaterial;
use App\Livewire\Database\Material\EditMaterial;
use App\Livewire\Database\Material\IndexMaterial;
use App\Livewire\Database\Material\ShowMaterial;
use App\Livewire\Database\MaterialKategori\CreateMaterialKategori;
use App\Livewire\Database\MaterialKategori\EditMaterialKategori;
use App\Livewire\Database\MaterialKategori\IndexMaterialKategori;
use App\Livewire\Database\MaterialKategori\ShowMaterialKategori;
use App\Livewire\Database\Supplier\CreateSupplier;
use App\Livewire\Database\Supplier\EditSupplier;
use App\Livewire\Database\Supplier\IndexSupplier;
use App\Livewire\Database\Supplier\ShowSupplier;
use Illuminate\Support\Facades\Route;

Route::prefix('database')->group(function() {
    Route::prefix('area')->name('area.')->group(function() {
        Route::get('/', IndexArea::class)->name('index');
        Route::get('/create', CreateArea::class)->name('create');
        Route::get('/show/{id}', ShowArea::class)->name('show');
        Route::get('/edit/{id}', EditArea::class)->name('edit');
        Route::delete('/{id}', [IndexArea::class, 'destroy'])->name('destroy');
    });

    Route::prefix('karyawan')->name('karyawan.')->group(function() {
        Route::get('/', IndexKaryawan::class)->name('index');
        Route::get('/create', CreateKaryawan::class)->name('create');
        Route::get('/show/{id}', ShowKaryawan::class)->name('show');
        Route::get('/edit/{id}', EditKaryawan::class)->name('edit');
        Route::delete('/{id}', [IndexKaryawan::class, 'destroy'])->name('destroy');
    });

    Route::prefix('material-kategori')->name('material-kategori.')->group(function() {
        Route::get('/', IndexMaterialKategori::class)->name('index');
        Route::get('/create', CreateMaterialKategori::class)->name('create');
        Route::get('/show/{id}', ShowMaterialKategori::class)->name('show');
        Route::get('/edit/{id}', EditMaterialKategori::class)->name('edit');
        Route::delete('/{id}', [IndexMaterialKategori::class, 'destroy'])->name('destroy');
    });

    Route::prefix('material')->name('material.')->group(function() {
        Route::get('/', IndexMaterial::class)->name('index');
        Route::get('/create', CreateMaterial::class)->name('create');
        Route::get('/show/{id}', ShowMaterial::class)->name('show');
        Route::get('/edit/{id}', EditMaterial::class)->name('edit');
        Route::delete('/{id}', [IndexMaterial::class, 'destroy'])->name('destroy');
    });

    Route::prefix('jabatan')->name('jabatan.')->group(function() {
        Route::get('/', IndexJabatan::class)->name('index');
        Route::get('/create', CreateJabatan::class)->name('create');
        Route::get('/show/{id}', ShowJabatan::class)->name('show');
        Route::get('/edit/{id}', EditJabatan::class)->name('edit');
        Route::delete('/{id}', [IndexJabatan::class, 'destroy'])->name('destroy');
    });

    Route::prefix('supplier')->name('supplier.')->group(function() {
        Route::get('/', IndexSupplier::class)->name('index');
        Route::get('/create', CreateSupplier::class)->name('create');
        Route::get('/show/{id}', ShowSupplier::class)->name('show');
        Route::get('/edit/{id}', EditSupplier::class)->name('edit');
        Route::delete('/{id}', [IndexSupplier::class, 'destroy'])->name('destroy');
    });

    Route::prefix('jenis-pengeluaran')->name('jenis-pengeluaran.')->group(function() {
        Route::get('/', IndexJenisPengeluaran::class)->name('index');
        Route::get('/create', CreateJenisPengeluaran::class)->name('create');
        Route::get('/show/{id}', ShowJenisPengeluaran::class)->name('show');
        Route::get('/edit/{id}', EditJenisPengeluaran::class)->name('edit');
        Route::delete('/{id}', [IndexJenisPengeluaran::class, 'destroy'])->name('destroy');
    });

    Route::prefix('jenis-pemasukan')->name('jenis-pemasukan.')->group(function() {
        Route::get('/', IndexJenisPemasukan::class)->name('index');
        Route::get('/create', CreateJenisPemasukan::class)->name('create');
        Route::get('/show/{id}', ShowJenisPemasukan::class)->name('show');
        Route::get('/edit/{id}', EditJenisPemasukan::class)->name('edit');
        Route::delete('/{id}', [IndexJenisPemasukan::class, 'destroy'])->name('destroy');
    });

    Route::prefix('jenis-rumah')->name('jenis-rumah.')->group(function() {
        Route::get('/', IndexJenisRumah::class)->name('index');
        Route::get('/create', CreateJenisRumah::class)->name('create');
        Route::get('/show/{id}', ShowJenisRumah::class)->name('show');
        Route::get('/edit/{id}', EditJenisRumah::class)->name('edit');
        Route::delete('/{id}', [IndexJenisRumah::class, 'destroy'])->name('destroy');
    });

    // Route::prefix('')->name('')->group(function() {
    //     Route::get('/', Index::class)->name('index');
    //     Route::get('/create', Create::class)->name('create');
    //     Route::get('/show/{id}', Show::class)->name('show');
    //     Route::get('/edit/{id}', Edit::class)->name('edit');
    //     Route::delete('/{id}', [Index::class, 'destroy'])->name('destroy');
    // });

    // Route::prefix('')->name('')->group(function() {
    //     Route::get('/', Index::class)->name('index');
    //     Route::get('/create', Create::class)->name('create');
    //     Route::get('/show/{id}', Show::class)->name('show');
    //     Route::get('/edit/{id}', Edit::class)->name('edit');
    //     Route::delete('/{id}', [Index::class, 'destroy'])->name('destroy');
    // });
});
