<?php

namespace Database\Seeders;

use App\Models\Structure;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'employee_id' => null,
                'area_id' => null,
                'name' => 'Root',
                'email' => 'root@system.com',
                'password' => Hash::make('password'),
                'active' => 1
            ],
            [
                'employee_id' => null,
                'area_id' => null,
                'name' => 'User',
                'email' => 'user@system.com',
                'password' => Hash::make('password'),
                'active' => 1
            ],
            // [
            //     'employee_id' => 1,
            //     'area_id' => 1,
            //     'name' => 'Muhammad Faris',
            //     'email' => 'kepalalogistik@gmail.com',
            //     'password' => Hash::make('password'),
            //     'active' => 1
            // ],
            // [
            //     'employee_id' => 2,
            //     'area_id' => 1,
            //     'name' => 'Muhammad Faris',
            //     'email' => 'adminlogistik@gmail.com',
            //     'password' => Hash::make('password'),
            //     'active' => 1
            // ],
            // [
            //     'employee_id' => 3,
            //     'area_id' => 1,
            //     'name' => 'Fahrul',
            //     'email' => 'marketing1@gmail.com',
            //     'password' => Hash::make('password'),
            //     'active' => 1
            // ],
        ];
        User::insert($data);

        $structures = Structure::all();

        foreach ($structures as $key => $value) {
            User::create([
                'employee_id' => $value->employee_id,
                'area_id' => $value->area_id,
                'name' => $value->employee->name,
                'email' => $value->employee->email,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
