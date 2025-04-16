<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $position = [
            [
                'name' => 'Kepala Logistik',
            ],
            [
                'name' => 'Admin Logistik',
            ],
        ];
        Position::insert($position);

        $area = [
            [
                'name' => 'Pusat',
                'address' => 'Alamat pusat',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        Area::insert($area);

        $karyawan = [
            [
                'identification_number' => '7371140507950007',
                'name' => 'Muhammad Faris',
                'address' => 'Jalan kapasa raya, bontojai',
                'place_of_birth' => 'Makassar',
                'date_of_birth' => '1995-07-05',
                'whatsapp_number' => '+6282194211212',
                'email' => 'kepalalogistik@gmail.com',
                'active' => 1
            ],
            [
                'identification_number' => '7621109238012013',
                'name' => 'Andir',
                'address' => 'Jalan perintis kemerdekaan',
                'place_of_birth' => 'Makassar',
                'date_of_birth' => '1995-12-20',
                'whatsapp_number' => '+6282186792255',
                'email' => 'adminlogistik@gmail.com',
                'active' => 1
            ],
        ];
        Employee::insert($karyawan);

        $struktur = [
            [
                'employee_id' => Employee::where('identification_number', '7371140507950007')->first()->id,
                'position_id' => Position::where('name', 'Kepala Logistik')->first()->id,
                'area_id' => Area::where('name', 'Pusat')->first()->id,
                'employee_number' => '13020130083'
            ],
            [
                'employee_id' => Employee::where('identification_number', '7621109238012013')->first()->id,
                'position_id' => Position::where('name', 'Admin Logistik')->first()->id,
                'area_id' => Area::where('name', 'Pusat')->first()->id,
                'employee_number' => '130201300811'
            ]
        ];
        Structure::insert($struktur);

        $user = [
            [
                'employee_id' => Employee::where('identification_number', '7371140507950007')->first()->id,
                'area_id' => Area::where('name', 'Pusat')->first()->id,
                'name' => 'Muhammad Faris',
                'email' => 'kepalalogistik@gmail.com',
                'password' => Hash::make('password'),
                'active' => 1
            ],
            [
                'employee_id' => Employee::where('identification_number', '7621109238012013')->first()->id,
                'area_id' => Area::where('name', 'Pusat')->first()->id,
                'name' => 'Andir',
                'email' => 'adminlogistik@gmail.com',
                'password' => Hash::make('password'),
                'active' => 1
            ],
        ];
        User::insert($user);
        $user1 = User::where('email', 'kepalalogistik@gmail.com')->first();
        $user1->assignRole('kepala logistik');

        $user2 = User::where('email', 'adminlogistik@gmail.com')->first();
        $user2->assignRole('admin logistik');

    }
}
