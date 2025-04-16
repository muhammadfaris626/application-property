<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\TypeOfHouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeOfHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = Area::all();
        foreach ($areas as $key => $value) {
            TypeOfHouse::factory(10)->create([
                'area_id' => $value->id
            ]);
        }
    }
}
