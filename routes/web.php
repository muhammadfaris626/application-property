<?php

use App\Livewire\Dashboard\IndexDashboard;
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
use App\Livewire\Karyawan\Mutasi\CreateMutasi;
use App\Livewire\Karyawan\Mutasi\EditMutasi;
use App\Livewire\Karyawan\Mutasi\IndexMutasi;
use App\Livewire\Karyawan\Mutasi\ShowMutasi;
use App\Livewire\Karyawan\Pemberhentian\CreatePemberhentian;
use App\Livewire\Karyawan\Pemberhentian\EditPemberhentian;
use App\Livewire\Karyawan\Pemberhentian\IndexPemberhentian;
use App\Livewire\Karyawan\Pemberhentian\ShowPemberhentian;
use App\Livewire\Kehadiran\IndexKehadiran;
use App\Livewire\Laporan\PembelianMaterial\LaporanPembelianMaterialIndex;
use App\Livewire\Pemasukan\KasBesar\CreatePemasukanKasBesar;
use App\Livewire\Pemasukan\KasBesar\EditPemasukanKasBesar;
use App\Livewire\Pemasukan\KasBesar\IndexPemasukanKasBesar;
use App\Livewire\Pemasukan\KasBesar\ShowPemasukanKasBesar;
use App\Livewire\Pemasukan\KasKecil\CreatePemasukanKasKecil;
use App\Livewire\Pemasukan\KasKecil\EditPemasukanKasKecil;
use App\Livewire\Pemasukan\KasKecil\IndexPemasukanKasKecil;
use App\Livewire\Pemasukan\KasKecil\ShowPemasukanKasKecil;
use App\Livewire\PembelianMaterial\CreatePembelianMaterial;
use App\Livewire\PembelianMaterial\EditPembelianMaterial;
use App\Livewire\PembelianMaterial\IndexPembelianMaterial;
use App\Livewire\PembelianMaterial\ShowPembelianMaterial;
use App\Livewire\Pengaturan\Akun\CreateAkun;
use App\Livewire\Pengaturan\Akun\EditAkun;
use App\Livewire\Pengaturan\Akun\IndexAkun;
use App\Livewire\Pengaturan\Akun\ShowAkun;
use App\Livewire\Pengaturan\Persetujuan\ApprovalStep\CreateApprovalStep;
use App\Livewire\Pengaturan\Persetujuan\ApprovalStep\EditApprovalStep;
use App\Livewire\Pengaturan\Persetujuan\CreatePersetujuan;
use App\Livewire\Pengaturan\Persetujuan\EditPersetujuan;
use App\Livewire\Pengaturan\Persetujuan\IndexPersetujuan;
use App\Livewire\Pengaturan\Persetujuan\ShowPersetujuan;
use App\Livewire\Penjualan\CalonUser\CreateCalonUser;
use App\Livewire\Penjualan\CalonUser\EditCalonUser;
use App\Livewire\Penjualan\CalonUser\IndexCalonUser;
use App\Livewire\Penjualan\CalonUser\ShowCalonUser;
use App\Livewire\Setting\User\IndexUser;
use App\Livewire\Struktur\CreateStruktur;
use App\Livewire\Struktur\EditStruktur;
use App\Livewire\Struktur\IndexStruktur;
use App\Livewire\Struktur\ShowStruktur;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

Route::middleware(['auth'])->group(function () {
    Route::get('/', IndexDashboard::class)->name('home');
    Route::get('dashboard', IndexDashboard::class)->name('dashboard.index');
    Route::get('kehadiran', IndexKehadiran::class)->name('kehadiran.index');
    foreach (glob(__DIR__ . '/partials/*.php') as $file) {
        require $file;
    }

    Route::get('/file/{folder}/{filename}', function ($folder, $filename) {
        $path = storage_path('app/public/' . $folder . '/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return Response::file($path);
    });
});

require __DIR__.'/auth.php';
