<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Material;
use App\Models\PermintaanMaterial;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermintaanMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = Material::inRandomOrder()->limit(4)->get();

        PermintaanMaterial::factory()
            ->count(100)
            ->create()
            ->each(function ($permintaan) use ($materials) {
                foreach ($materials as $material) {
                    DB::table('list_permintaan_materials')->insert([
                        'permintaan_material_id' => $permintaan->id,
                        'material_id' => $material->id,
                        'quantity' => rand(1, 10),
                        'approved_quantity' => rand(0, 10),
                        'created_at' => $permintaan->created_at,
                        'updated_at' => $permintaan->updated_at,
                    ]);
                }
            });
    }
}
