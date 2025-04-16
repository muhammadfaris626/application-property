<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area::factory(50)->create();
        // $data = [
        //     [
        //         'name' => 'Pusat',
        //         'address' => 'Alamat pusat',
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'name' => 'Area Makassar',
        //         'address' => 'Alamat makassar',
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        //     [
        //         'name' => 'Area Maros',
        //         'address' => 'Alamat maros',
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ],
        // ];
        // Area::insert($data);
    }
}
