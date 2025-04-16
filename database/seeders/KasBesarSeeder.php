<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\KasBesar;
use App\Models\ListKasBesar;
use App\Models\TypeOfExpenditure;
use App\Models\TypeOfIncome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KasBesarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            KasBesar::factory()
                ->count(3)
                ->create(['employee_id' => $employee->id])
                ->each(function($kas) {
                    for ($i=0; $i < 2; $i++) {
                        $data = [
                            'kas_besar_id' => $kas->id,
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

                        ListKasBesar::create($data);
                    }
                });
        }
    }
}
