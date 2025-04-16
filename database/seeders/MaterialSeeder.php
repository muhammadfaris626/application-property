<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Material::factory(10)->create();
        $categories = MaterialCategory::all();
        foreach ($categories as $key => $value) {
            Material::factory(10)->create([
                'material_category_id' => $value->id
            ]);
        }
    }
}
