<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = Position::factory(50)->create();

        // $manualPosition = Position::create([
        //     'name' => 'Kepala Logistik'
        // ]);
        // $positions->push($manualPosition);

        // $data = [
        //     [
        //         'name' => 'Kepala Logistik',
        //     ],
        //     [
        //         'name' => 'Admin Logistik',
        //     ],
        //     [
        //         'name' => 'Marketing',
        //     ],
        // ];

        // Position::insert($data);
    }
}
