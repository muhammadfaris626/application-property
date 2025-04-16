<?php

use App\Livewire\Pemasukan\KasBesar\CreatePemasukanKasBesar;
use App\Livewire\Pemasukan\KasBesar\EditPemasukanKasBesar;
use App\Livewire\Pemasukan\KasBesar\IndexPemasukanKasBesar;
use App\Livewire\Pemasukan\KasBesar\ShowPemasukanKasBesar;
use App\Livewire\Pemasukan\KasKecil\CreatePemasukanKasKecil;
use App\Livewire\Pemasukan\KasKecil\EditPemasukanKasKecil;
use App\Livewire\Pemasukan\KasKecil\IndexPemasukanKasKecil;
use App\Livewire\Pemasukan\KasKecil\ShowPemasukanKasKecil;
use App\Livewire\Pemasukan\Pendapatan\CreatePendapatan;
use App\Livewire\Pemasukan\Pendapatan\EditPendapatan;
use App\Livewire\Pemasukan\Pendapatan\IndexPendapatan;
use App\Livewire\Pemasukan\Pendapatan\ShowPendapatan;
use App\Livewire\Pengeluaran\KasBesar\CreatePengeluaranKasBesar;
use App\Livewire\Pengeluaran\KasBesar\EditPengeluaranKasBesar;
use App\Livewire\Pengeluaran\KasBesar\IndexPengeluaranKasBesar;
use App\Livewire\Pengeluaran\KasBesar\ShowPengeluaranKasBesar;
use App\Livewire\Pengeluaran\KasKecil\CreatePengeluaranKasKecil;
use App\Livewire\Pengeluaran\KasKecil\EditPengeluaranKasKecil;
use App\Livewire\Pengeluaran\KasKecil\IndexPengeluaranKasKecil;
use App\Livewire\Pengeluaran\KasKecil\ShowPengeluaranKasKecil;
use App\Livewire\Pengeluaran\PengajuanInvoice\ApprovalPengajuanInvoice;
use App\Livewire\Pengeluaran\PengajuanInvoice\CreatePengajuanInvoice;
use App\Livewire\Pengeluaran\PengajuanInvoice\EditPengajuanInvoice;
use App\Livewire\Pengeluaran\PengajuanInvoice\IndexPengajuanInvoice;
use App\Livewire\Pengeluaran\PengajuanInvoice\ShowPengajuanInvoice;
use Illuminate\Support\Facades\Route;

Route::prefix('pemasukan-dan-pengeluaran')->group(function() {
    Route::prefix('pemasukan')->group(function() {
        Route::prefix('pemasukan-kas-besar')->name('pemasukan-kas-besar.')->group(function() {
            Route::get('/', IndexPemasukanKasBesar::class)->name('index');
            Route::get('/create', CreatePemasukanKasBesar::class)->name('create');
            Route::get('/show/{id}', ShowPemasukanKasBesar::class)->name('show');
            Route::get('/edit/{id}', EditPemasukanKasBesar::class)->name('edit');
            Route::delete('/{id}', [IndexPemasukanKasBesar::class, 'destroy'])->name('destroy');
        });
        Route::prefix('pemasukan-kas-kecil')->name('pemasukan-kas-kecil.')->group(function() {
            Route::get('/', IndexPemasukanKasKecil::class)->name('index');
            Route::get('/create', CreatePemasukanKasKecil::class)->name('create');
            Route::get('/show/{id}', ShowPemasukanKasKecil::class)->name('show');
            Route::get('/edit/{id}', EditPemasukanKasKecil::class)->name('edit');
            Route::delete('/{id}', [IndexPemasukanKasKecil::class, 'destroy'])->name('destroy');
        });

        Route::prefix('pemasukan-pendapatan')->name('pemasukan-pendapatan.')->group(function() {
            Route::get('/', IndexPendapatan::class)->name('index');
            Route::get('/create', CreatePendapatan::class)->name('create');
            Route::get('/show/{id}', ShowPendapatan::class)->name('show');
            Route::get('/edit/{id}', EditPendapatan::class)->name('edit');
            Route::delete('/{id}', [IndexPendapatan::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('pengeluaran')->group(function() {
        Route::prefix('pengeluaran-kas-besar')->name('pengeluaran-kas-besar.')->group(function() {
            Route::get('/', IndexPengeluaranKasBesar::class)->name('index');
            Route::get('/create', CreatePengeluaranKasBesar::class)->name('create');
            Route::get('/show/{id}', ShowPengeluaranKasBesar::class)->name('show');
            Route::get('/edit/{id}', EditPengeluaranKasBesar::class)->name('edit');
            Route::delete('/{id}', [IndexPengeluaranKasBesar::class, 'destroy'])->name('destroy');
        });
        Route::prefix('pengeluaran-kas-kecil')->name('pengeluaran-kas-kecil.')->group(function() {
            Route::get('/', IndexPengeluaranKasKecil::class)->name('index');
            Route::get('/create', CreatePengeluaranKasKecil::class)->name('create');
            Route::get('/show/{id}', ShowPengeluaranKasKecil::class)->name('show');
            Route::get('/edit/{id}', EditPengeluaranKasKecil::class)->name('edit');
            Route::delete('/{id}', [IndexPengeluaranKasKecil::class, 'destroy'])->name('destroy');
        });
        Route::prefix('pengajuan-invoice')->name('pengajuan-invoice.')->group(function() {
            Route::get('/', IndexPengajuanInvoice::class)->name('index');
            Route::get('/create', CreatePengajuanInvoice::class)->name('create');
            Route::get('/show/{id}', ShowPengajuanInvoice::class)->name('show');
            Route::get('/edit/{id}', EditPengajuanInvoice::class)->name('edit');
            Route::delete('/{id}', [IndexPengajuanInvoice::class, 'destroy'])->name('destroy');
            Route::get('/approval/{id}', ApprovalPengajuanInvoice::class)->name('approval');
        });
    });



    // Route::prefix('')->name('')->group(function() {
    //     Route::get('/', Index::class)->name('index');
    //     Route::get('/create', Create::class)->name('create');
    //     Route::get('/show/{id}', Show::class)->name('show');
    //     Route::get('/edit/{id}', Edit::class)->name('edit');
    //     Route::delete('/{id}', [Index::class, 'destroy'])->name('destroy');
    // });
});


// Route::get('/', Index::class)->name('index');
// Route::get('/create', Create::class)->name('create');
// Route::get('/show/{id}', Show::class)->name('show');
// Route::get('/edit/{id}', Edit::class)->name('edit');
// Route::delete('/{id}', [Index::class, 'destroy'])->name('destroy');
