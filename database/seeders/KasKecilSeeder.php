<?php

namespace Database\Seeders;

use App\Models\KasKecil;
use App\Models\ListKasKecil;
use App\Models\Structure;
use App\Models\TypeOfExpenditure;
use App\Models\TypeOfIncome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KasKecilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua struktur agar dapat pasangan employee_id dan area_id
        $structures = Structure::all();

        foreach ($structures as $structure) {
            for ($i = 0; $i < 3; $i++) {
                $kas = KasKecil::factory()->create([
                    'employee_id' => $structure->employee_id,
                    'area_id' => $structure->area_id,
                ]);

                for ($j = 0; $j < 2; $j++) {
                    $data = [
                        'kas_kecil_id' => $kas->id,
                        'desc' => fake()->sentence,
                        'total' => fake()->randomFloat(2, 50000, 500000),
                        'created_at' => $kas->created_at,
                        'updated_at' => $kas->updated_at,
                    ];

                    if ($kas->category === 'Pemasukan') {
                        $data['type_of_income_id'] = TypeOfIncome::inRandomOrder()->first()?->id ?? 1;
                        $data['type_of_expenditure_id'] = null;
                    } else {
                        $data['type_of_expenditure_id'] = TypeOfExpenditure::inRandomOrder()->first()?->id ?? 1;
                        $data['type_of_income_id'] = null;
                    }

                    ListKasKecil::create($data);
                }
            }
        }
    }
}
