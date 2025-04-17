<?php

return [
    'Platform' => [
        'Platform' => [
            'Dashboard' => [
                'label'      => 'Dashboard',
                'route'      => 'dashboard.index',
                'routes'     => ['dashboard.index'],
                'permission' => 'dashboard: menu',
                'icon'       => 'home',
                'badge' => 'Pro',
                'badge_color' => 'green',
            ],
            'Kehadiran' => [
                'label'      => 'Kehadiran',
                'route'      => 'kehadiran.index',
                'routes'     => ['kehadiran.index'],
                'permission' => 'kehadiran: menu',
                'icon'       => 'finger-print'
            ]
        ]
    ],
    'Penjualan' => [
        'Penjualan' => [
            'Penjualan' => [
                [
                    'label'      => 'Calon User',
                    'route'      => 'calon-user.index',
                    'routes'     => ['calon-user.index', 'calon-user.create', 'calon-user.show', 'calon-user.edit'],
                    'permission' => 'calon-user: menu',
                    'icon'       => 'user-plus'
                ],
                [
                    'label'      => 'User',
                    'route'      => 'customer.index',
                    'routes'     => ['customer.index', 'customer.create', 'customer.show', 'customer.edit'],
                    'permission' => 'customer: menu',
                    'icon'       => 'user'
                ],
                [
                    'label'      => 'Kartu Kontrol',
                    'route'      => 'kartu-kontrol.index',
                    'routes'     => ['kartu-kontrol.index', 'kartu-kontrol.create', 'kartu-kontrol.show', 'kartu-kontrol.edit'],
                    'permission' => 'kartu-kontrol: menu',
                    'icon'       => 'document-check'
                ],
            ]
        ]
    ],
    'Logistik' => [
        'Logistik' => [
            'Pembelian Material' => [
                'label'      => 'Pembelian Material',
                'route'      => 'pembelian-material.index',
                'routes'     => ['pembelian-material.index', 'pembelian-material.create', 'pembelian-material.show', 'pembelian-material.edit'],
                'permission' => 'pembelian-material: menu',
                'icon'       => 'archive-box-arrow-down'
            ],
            'Permintaan Material' => [
                'label'      => 'Permintaan Material',
                'route'      => 'permintaan-material.index',
                'routes'     => ['permintaan-material.index', 'permintaan-material.create', 'permintaan-material.show', 'permintaan-material.edit'],
                'permission' => 'permintaan-material: menu',
                'icon'       => 'inbox-stack'
            ]
        ]
    ],
    'PemasukanPengeluaran' => [
        'Pemasukan dan Pengeluaran' => [
            'Pemasukan' => [
                [
                    'label'      => 'Kas Besar',
                    'route'      => 'pemasukan-kas-besar.index',
                    'routes'     => ['pemasukan-kas-besar.index', 'pemasukan-kas-besar.create', 'pemasukan-kas-besar.show', 'pemasukan-kas-besar.edit'],
                    'permission' => 'pemasukan-kas-besar: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Kas Kecil',
                    'route'      => 'pemasukan-kas-kecil.index',
                    'routes'     => ['pemasukan-kas-kecil.index', 'pemasukan-kas-kecil.create', 'pemasukan-kas-kecil.show', 'pemasukan-kas-kecil.edit'],
                    'permission' => 'pemasukan-kas-kecil: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Pendapatan',
                    'route'      => 'pemasukan-pendapatan.index',
                    'routes'     => ['pemasukan-pendapatan.index', 'pemasukan-pendapatan.create', 'pemasukan-pendapatan.show', 'pemasukan-pendapatan.edit'],
                    'permission' => 'pemasukan-pendapatan: menu',
                    'icon'       => 'queue-list'
                ],
            ],
            'Pengeluaran' => [
                [
                    'label'      => 'Pengajuan Invoice',
                    'route'      => 'pengajuan-invoice.index',
                    'routes'     => ['pengajuan-invoice.index', 'pengajuan-invoice.create', 'pengajuan-invoice.show', 'pengajuan-invoice.edit'],
                    'permission' => 'pengajuan-invoice: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Kas Besar',
                    'route'      => 'pengeluaran-kas-besar.index',
                    'routes'     => ['pengeluaran-kas-besar.index', 'pengeluaran-kas-besar.create', 'pengeluaran-kas-besar.show', 'pengeluaran-kas-besar.edit'],
                    'permission' => 'pengeluaran-kas-besar: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Kas Kecil',
                    'route'      => 'pengeluaran-kas-kecil.index',
                    'routes'     => ['pengeluaran-kas-kecil.index', 'pengeluaran-kas-kecil.create', 'pengeluaran-kas-kecil.show', 'pengeluaran-kas-kecil.edit'],
                    'permission' => 'pengeluaran-kas-kecil: menu',
                    'icon'       => 'queue-list'
                ],
            ]
        ]
    ],
    'Management' => [
        'Management' => [
            'Laporan' => [
                [
                    'label'      => 'Pembelian Material',
                    'route'      => 'laporan-pembelian-material.index',
                    'routes'     => ['laporan-pembelian-material.index'],
                    'permission' => 'laporan-pembelian-material: menu',
                    'icon'       => 'clipboard-document-list'
                ],
                [
                    'label'      => 'Kas Besar',
                    'route'      => 'laporan-kas-besar.index',
                    'routes'     => ['laporan-kas-besar.index'],
                    'permission' => 'laporan-kas-besar: menu',
                    'icon'       => 'clipboard-document-list'
                ],
                [
                    'label'      => 'Kas Kecil',
                    'route'      => 'laporan-kas-kecil.index',
                    'routes'     => ['laporan-kas-kecil.index'],
                    'permission' => 'laporan-kas-kecil: menu',
                    'icon'       => 'clipboard-document-list'
                ],
                [
                    'label'      => 'Pengajuan Invoice',
                    'route'      => 'laporan-pengajuan-invoice.index',
                    'routes'     => ['laporan-pengajuan-invoice.index'],
                    'permission' => 'laporan-pengajuan-invoice: menu',
                    'icon'       => 'clipboard-document-list'
                ],
                [
                    'label'      => 'Permintaan Material',
                    'route'      => 'laporan-permintaan-material.index',
                    'routes'     => ['laporan-permintaan-material.index'],
                    'permission' => 'laporan-permintaan-material: menu',
                    'icon'       => 'clipboard-document-list'
                ],
                [
                    'label'      => 'Data Jaminan User',
                    'route'      => 'laporan-data-jaminan-user.index',
                    'routes'     => ['laporan-data-jaminan-user.index'],
                    'permission' => 'laporan-data-jaminan-user: menu',
                    'icon'       => 'clipboard-document-list'
                ],
                [
                    'label'      => 'User',
                    'route'      => 'laporan-penjualan-user.index',
                    'routes'     => ['laporan-penjualan-user.index'],
                    'permission' => 'laporan-penjualan-user: menu',
                    'icon'       => 'clipboard-document-list'
                ],
                [
                    'label'      => 'Pendapatan',
                    'route'      => 'laporan-pendapatan.index',
                    'routes'     => ['laporan-pendapatan.index'],
                    'permission' => 'laporan-pendapatan: menu',
                    'icon'       => 'clipboard-document-list'
                ],
                [
                    'label'      => 'Absensi',
                    'route'      => 'laporan-absensi.index',
                    'routes'     => ['laporan-absensi.index'],
                    'permission' => 'laporan-absensi: menu',
                    'icon'       => 'clipboard-document-list'
                ],
            ],
            'Karyawan' => [
                [
                    'label'      => 'Absensi',
                    'route'      => 'absensi.index',
                    'routes'     => ['absensi.index', 'absensi.create', 'absensi.show', 'absensi.edit'],
                    'permission' => 'absensi: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Kinerja',
                    'route'      => 'kinerja.index',
                    'routes'     => ['kinerja.index', 'kinerja.create', 'kinerja.show', 'kinerja.edit'],
                    'permission' => 'kinerja: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Profil',
                    'route'      => 'profil.index',
                    'routes'     => ['profil.index', 'profil.create', 'profil.show', 'profil.edit'],
                    'permission' => 'profil: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Mutasi',
                    'route'      => 'mutasi.index',
                    'routes'     => ['mutasi.index', 'mutasi.create', 'mutasi.show', 'mutasi.edit'],
                    'permission' => 'mutasi: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Pemberhentian',
                    'route'      => 'pemberhentian.index',
                    'routes'     => ['pemberhentian.index', 'pemberhentian.create', 'pemberhentian.show', 'pemberhentian.edit'],
                    'permission' => 'pemberhentian: menu',
                    'icon'       => 'queue-list'
                ],
            ],
            'Struktur Management' => [
                'label'      => 'Struktur Management',
                'route'      => 'struktur.index',
                'routes'     => ['struktur.index', 'struktur.create', 'struktur.show', 'struktur.edit'],
                'permission' => 'struktur: menu',
                'icon'       => 'rectangle-group'
            ]
        ]
    ],
    'Database' => [
        'Database' => [
            'Database' => [
                [
                    'label'      => 'Area',
                    'route'      => 'area.index',
                    'routes'     => ['area.index', 'area.create', 'area.show', 'area.edit'],
                    'permission' => 'area: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Karyawan',
                    'route'      => 'karyawan.index',
                    'routes'     => ['karyawan.index', 'karyawan.create', 'karyawan.show', 'karyawan.edit'],
                    'permission' => 'karyawan: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Material Kategori',
                    'route'      => 'material-kategori.index',
                    'routes'     => ['material-kategori.index', 'material-kategori.create', 'material-kategori.show', 'material-kategori.edit'],
                    'permission' => 'material-kategori: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Material',
                    'route'      => 'material.index',
                    'routes'     => ['material.index', 'material.create', 'material.show', 'material.edit'],
                    'permission' => 'material: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Jabatan',
                    'route'      => 'jabatan.index',
                    'routes'     => ['jabatan.index', 'jabatan.create', 'jabatan.show', 'jabatan.edit'],
                    'permission' => 'jabatan: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Supplier',
                    'route'      => 'supplier.index',
                    'routes'     => ['supplier.index', 'supplier.create', 'supplier.show', 'supplier.edit'],
                    'permission' => 'supplier: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Jenis Pengeluaran',
                    'route'      => 'jenis-pengeluaran.index',
                    'routes'     => ['jenis-pengeluaran.index', 'jenis-pengeluaran.create', 'jenis-pengeluaran.show', 'jenis-pengeluaran.edit'],
                    'permission' => 'jenis-pengeluaran: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Jenis Pemasukan',
                    'route'      => 'jenis-pemasukan.index',
                    'routes'     => ['jenis-pemasukan.index', 'jenis-pemasukan.create', 'jenis-pemasukan.show', 'jenis-pemasukan.edit'],
                    'permission' => 'jenis-pemasukan: menu',
                    'icon'       => 'queue-list'
                ],
                [
                    'label'      => 'Jenis Rumah',
                    'route'      => 'jenis-rumah.index',
                    'routes'     => ['jenis-rumah.index', 'jenis-rumah.create', 'jenis-rumah.show', 'jenis-rumah.edit'],
                    'permission' => 'jenis-rumah: menu',
                    'icon'       => 'queue-list'
                ],
            ],
            'Pengaturan' => [
                [
                    'label'      => 'Persetujuan',
                    'route'      => 'persetujuan.index',
                    'routes'     => ['persetujuan.index', 'persetujuan.create', 'persetujuan.show', 'persetujuan.edit'],
                    'permission' => 'persetujuan: menu',
                    'icon'       => 'document-check'
                ],
                [
                    'label'      => 'Akun',
                    'route'      => 'akun.index',
                    'routes'     => ['akun.index', 'akun.create', 'akun.show', 'akun.edit'],
                    'permission' => 'akun: menu',
                    'icon'       => 'users'
                ],
                [
                    'label'      => 'Peran',
                    'route'      => 'peran.index',
                    'routes'     => ['peran.index', 'peran.create', 'peran.show', 'peran.edit'],
                    'permission' => 'peran: menu',
                    'icon'       => 'key'
                ],
                [
                    'label'      => 'Perizinan',
                    'route'      => 'perizinan.index',
                    'routes'     => ['perizinan.index', 'perizinan.create', 'perizinan.show', 'perizinan.edit'],
                    'permission' => 'perizinan: menu',
                    'icon'       => 'finger-print'
                ],
            ]
        ]
    ]
];
