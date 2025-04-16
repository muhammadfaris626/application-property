<?php

namespace Database\Seeders;

use App\Models\TypeOfExpenditure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeOfExpenditureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeOfExpenditure::factory(50)->create();
    }
}
