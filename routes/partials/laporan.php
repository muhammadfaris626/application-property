<?php

use App\Livewire\Laporan\Absensi\IndexLaporanAbsensi;
use App\Livewire\Laporan\DataJaminanUser\LaporanDataJaminanUserIndex;
use App\Livewire\Laporan\KasBesar\LaporanKasBesarIndex;
use App\Livewire\Laporan\KasKecil\LaporanKasKecilIndex;
use App\Livewire\Laporan\PembelianMaterial\LaporanPembelianMaterialIndex;
use App\Livewire\Laporan\Pendapatan\IndexLaporanPendapatan;
use App\Livewire\Laporan\PengajuanInvoice\LaporanPengajuanInvoiceIndex;
use App\Livewire\Laporan\RequestOrder\LaporanRequestOrderIndex;
use App\Livewire\Laporan\User\IndexLaporanUser;
use Illuminate\Support\Facades\Route;

Route::prefix('laporan')->group(function() {
    Route::prefix('laporan-pembelian-material')->name('laporan-pembelian-material.')->group(function() {
        Route::get('/', LaporanPembelianMaterialIndex::class)->name('index');
    });
    Route::prefix('laporan-kas-besar')->name('laporan-kas-besar.')->group(function() {
        Route::get('/', LaporanKasBesarIndex::class)->name('index');
    });
    Route::prefix('laporan-kas-kecil')->name('laporan-kas-kecil.')->group(function() {
        Route::get('/', LaporanKasKecilIndex::class)->name('index');
    });
    Route::prefix('laporan-pengajuan-invoice')->name('laporan-pengajuan-invoice.')->group(function() {
        Route::get('/', LaporanPengajuanInvoiceIndex::class)->name('index');
    });

    Route::prefix('laporan-permintaan-material')->name('laporan-permintaan-material.')->group(function() {
        Route::get('/', LaporanRequestOrderIndex::class)->name('index');
    });

    Route::prefix('laporan-data-jaminan-user')->name('laporan-data-jaminan-user.')->group(function() {
        Route::get('/', LaporanDataJaminanUserIndex::class)->name('index');
    });

    Route::prefix('laporan-pendapatan')->name('laporan-pendapatan.')->group(function() {
        Route::get('/', IndexLaporanPendapatan::class)->name('index');
    });

    Route::prefix('laporan-penjualan-user')->name('laporan-penjualan-user.')->group(function() {
        Route::get('/', IndexLaporanUser::class)->name('index');
    });

    Route::prefix('laporan-absensi')->name('laporan-absensi.')->group(function() {
        Route::get('/', IndexLaporanAbsensi::class)->name('index');
    });

    // Route::prefix('')->name('.')->group(function() {
    //     Route::get('/', ::class)->name('index');
    // });
});
