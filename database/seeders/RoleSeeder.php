<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Root',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'User',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kepala Logistik',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Admin Logistik',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        Role::insert($data);
    }
}
