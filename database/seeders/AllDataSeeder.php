<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AllDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'employee_id' => null,
            'area_id' => null,
            'name' => 'Root',
            'email' => 'root@system.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
