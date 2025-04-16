<?php

namespace Database\Seeders;

use App\Models\TypeOfIncome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeOfIncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeOfIncome::factory(50)->create();
    }
}
