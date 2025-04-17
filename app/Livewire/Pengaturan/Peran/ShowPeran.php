<?php

namespace App\Livewire\Pengaturan\Peran;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleHasPermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class ShowPeran extends Component
{
    public $id, $show, $fetch;

    public function mount($id) {
        $this->show = Role::find($id);
        Gate::authorize('view', $this->show);
        $this->fetch = $this->permission();
    }
    public function render()
    {
        return view('livewire.pengaturan.peran.show-peran');
    }

    public function permission() {
        $allPermissions = [
            // Platform
            'dashboard', 'kehadiran',
            // Penjualan
            'calon-user', 'customer', 'kartu-kontrol',
            // Logistik
            'pembelian-material', 'permintaan-material',
            // Pemasukan dan Pengeluaran
            'pemasukan-kas-besar', 'pemasukan-kas-kecil', 'pemasukan-pendapatan',
            'pengajuan-invoice', 'pengeluaran-kas-besar', 'pengeluaran-kas-kecil',
            // Management
            'laporan-pembelian-material', 'laporan-kas-besar', 'laporan-kas-kecil', 'laporan-pengajuan-invoice', 'laporan-permintaan-material', 'laporan-data-jaminan-user', 'laporan-penjualan-user', 'laporan-pendapatan',
            'laporan-absensi',
            'absensi', 'kinerja', 'profil', 'mutasi', 'pemberhentian',
            'struktur',
            // Database
            'area', 'karyawan', 'material-kategori', 'material', 'jabatan', 'supplier', 'jenis-pengeluaran', 'jenis-pemasukan', 'jenis-rumah',
            // Pengaturan
            'persetujuan', 'akun', 'peran', 'perizinan',
        ];
        $categoryNames = [
            // Platform
            'dashboard' => 'DASHBOARD',
            'kehadiran' => 'KEHADIRAN',
            // Penjualan
            'calon-user' => 'CALON USER',
            'customer' => 'USER',
            'kartu-kontrol' => 'KARTU KONTROL',
            // Logistik
            'pembelian-material' => 'PEMBELIAN MATERIAL',
            'permintaan-material' => 'PERMINTAAN MATERIAL',
            // Pemasukan dan Pengeluaran
            'pemasukan-kas-besar' => 'PEMASUKAN KAS BESAR',
            'pemasukan-kas-kecil' => 'PEMASUKAN KAS KECIL',
            'pemasukan-pendapatan' => 'PEMASUKAN PENDAPATAN',
            'pengajuan-invoice' => 'PENGAJUAN INVOICE',
            'pengeluaran-kas-besar' => 'PENGELUARAN KAS BESAR',
            'pengeluaran-kas-kecil' => 'PENGELUARAN KAS KECIL',
            // Management
            'laporan-pembelian-material' => 'LAPORAN PEMBELIAN MATERIAL',
            'laporan-kas-besar' => 'LAPORAN KAS BESAR',
            'laporan-kas-kecil' => 'LAPORAN KAS KECIL',
            'laporan-pengajuan-invoice' => 'LAPORAN PENGAJUAN INVOICE',
            'laporan-permintaan-material' => 'LAPORAN PERMINTAAN MATERIAL',
            'laporan-data-jaminan-user' => 'LAPORAN DATA JAMINAN USER',
            'laporan-penjualan-user' => 'LAPORAN PENJUALAN USER',
            'laporan-pendapatan' => 'LAPORAN PENDAPATAN',
            'laporan-absensi' => 'LAPORAN ABSENSI',
            'absensi' => 'ABSENSI',
            'kinerja' => 'KINERJA',
            'profil' => 'PROFIL',
            'mutasi' => 'MUTASI',
            'pemberhentian' => 'PEMBERHENTIAN',
            'struktur' => 'STRUKTUR MANAGEMENT',
            // Database
            'area' => 'AREA',
            'karyawan' => 'KARYAWAN',
            'material-kategori' => 'MATERIAL KATEGORI',
            'material' => 'MATERIAL',
            'jabatan' => 'JABATAN',
            'supplier' => 'SUPPLIER',
            'jenis-pengeluaran' => 'JENIS PENGELUARAN',
            'jenis-pemasukan' => 'JENIS PEMASUKAN',
            'jenis-rumah' => 'JENIS RUMAH',
            // Pengaturan
            'persetujuan' => 'PERSETUJUAN',
            'akun' => 'AKUN',
            'peran' => 'PERAN',
            'perizinan' => 'PERIZINAN',
        ];
        $list = [];
        $order = ['menu', 'create', 'read', 'update', 'delete'];
        foreach ($allPermissions as $key => $value) {
            $displayName = $categoryNames[$value] ?? $value;
            $list[$key] = [
                0 => 'role_id',
                1 => $this->show->id,
                'category' => $displayName
            ];
            $query = Permission::query();
            $query->where('name', 'REGEXP', "^" . preg_quote($value) . "(:|$)");
            $permissions = $query->get()->sortBy(function ($perm) use ($order) {
                $parts = explode(':', $perm->name);
                $suffix = $parts[1] ?? 'menu'; // default ke "menu" kalau tidak ada suffix
                return array_search($suffix, $order) !== false ? array_search($suffix, $order) : 999;
            });
            foreach ($permissions as $data) {
                $check = DB::table('role_has_permissions')
                    ->where('role_id', $this->show->id)
                    ->where('permission_id', $data->id)
                    ->exists();
                $status = $check ? 1 : 0;
                $list[$key][$displayName][$data->id] = [
                    'id' => $data->id,
                    'name' => $data->name,
                    'status' => $status
                ];
            }
        }
        return $list;
    }

    public function updatePermission($role, $permission) {
        $checkRolePermission = DB::table('role_has_permissions')->where('role_id', $role)->where('permission_id', $permission)->first();
        $searchRole = Role::where('id', $role)->first();
        $searchPermission = Permission::where('id', $permission)->first();
        if (empty($checkRolePermission)) {
            $searchRole->givePermissionTo($searchPermission);
            $searchPermission->assignRole($searchRole);
            LivewireAlert::text('Perizinan ditambahkan.')->success()->toast()->position('top-end')->show();
        } else {
            $searchRole->revokePermissionTo($searchPermission);
            $searchPermission->removeRole($searchRole);
            LivewireAlert::text('Perizinan dihapus.')->success()->toast()->position('top-end')->show();
        }
        return back();
    }
}
