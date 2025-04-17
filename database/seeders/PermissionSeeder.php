<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        app()['cache']->forget('spatie.permission.cache');

        $entities = [
            // Platform
            'dashboard', 'kehadiran',
            // Produk => Penjualan
            'calon-user', 'customer', 'kartu-kontrol',
            // Logistik
            'pembelian-material', 'permintaan-material',
            // Pemasukan dan Pengeluaran => Pemasukan
            'pemasukan-kas-besar', 'pemasukan-kas-kecil', 'pemasukan-pendapatan',
            // Pemasukan dan Pengeluaran  => Pengeluaran
            'pengajuan-invoice', 'pengeluaran-kas-besar', 'pengeluaran-kas-kecil',
            // Management => Laporan
            'laporan-pembelian-material', 'laporan-kas-besar', 'laporan-kas-kecil', 'laporan-pengajuan-invoice', 'laporan-permintaan-material',
            'laporan-data-jaminan-user', 'laporan-penjualan-user', 'laporan-pendapatan', 'laporan-absensi',
            // Management => Karyawan
            'absensi', 'kinerja', 'profil', 'mutasi', 'pemberhentian',
            // Management => Struktur Management
            'struktur',
            // Database => Database
            'area', 'karyawan', 'material-kategori', 'material', 'jabatan', 'supplier', 'jenis-pengeluaran', 'jenis-pemasukan', 'jenis-rumah',
            // Database => Pengaturan
            'persetujuan', 'akun', 'peran', 'perizinan',
        ];

        $actions = ['menu', 'create', 'read', 'update', 'delete'];

        $permissions = [];
        foreach ($entities as $entity) {
            foreach ($actions as $action) {
                $permissions["{$entity}: {$action}"] = Permission::create(['name' => "{$entity}: {$action}"]);
            }
        }

        $rolesPermissions = [
            'root' => Permission::all(),
            'user' => Permission::whereIn('name', [

            ])->get(),
            'kepala logistik' => Permission::whereIn('name', [
                'permintaan-material: menu', 'permintaan-material: create', 'permintaan-material: update', 'permintaan-material: read',
                'pengajuan-invoice: menu', 'pengajuan-invoice: create', 'pengajuan-invoice: update', 'pengajuan-invoice: read'
            ])->get(),
            'admin logistik' => Permission::whereIn('name', [
                'permintaan-material: menu', 'permintaan-material: create', 'permintaan-material: update', 'permintaan-material: read',
                'pengajuan-invoice: menu', 'pengajuan-invoice: create', 'pengajuan-invoice: update', 'pengajuan-invoice: read'
            ])->get(),
        ];

        foreach ($rolesPermissions as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($perms);
        }

        $user = User::where('email', 'root@system.com')->first();
        $user->assignRole('root');
        // $user1 = User::where('email', 'user@system.com')->first();
        // $user1->assignRole('user');
    }
}
