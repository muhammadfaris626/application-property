<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $data = [
        //     [
        //         'identification_number' => '7371140507950007',
        //         'name' => 'Muhammad Faris',
        //         'address' => 'Jalan kapasa raya, bontojai',
        //         'place_of_birth' => 'Makassar',
        //         'date_of_birth' => '1995-07-05',
        //         'whatsapp_number' => '+6282194211212',
        //         'email' => 'kepalalogistik@gmail.com',
        //         'active' => 1
        //     ],
        //     [
        //         'identification_number' => '7621109238012013',
        //         'name' => 'Andir',
        //         'address' => 'Jalan perintis kemerdekaan',
        //         'place_of_birth' => 'Makassar',
        //         'date_of_birth' => '1995-12-20',
        //         'whatsapp_number' => '+6282186792255',
        //         'email' => 'adminlogistik@gmail.com',
        //         'active' => 1
        //     ],
        //     [
        //         'identification_number' => '7621120238012999',
        //         'name' => 'Fahrul',
        //         'address' => 'Jalan katimbang',
        //         'place_of_birth' => 'Makassar',
        //         'date_of_birth' => '1995-03-25',
        //         'whatsapp_number' => '+6282176239756',
        //         'email' => 'marketing1@gmail.com',
        //         'active' => 1
        //     ],
        // ];
        // Employee::insert($data);
        Employee::factory(50)->create();
    }
}
