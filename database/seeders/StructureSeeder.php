<?php

namespace Database\Seeders;

use App\Models\Structure;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $structures = Structure::factory(50)->create();
    }
}
