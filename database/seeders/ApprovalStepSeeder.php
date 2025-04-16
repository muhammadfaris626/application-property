<?php

namespace Database\Seeders;

use App\Models\ApprovalStep;
use App\Models\Area;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApprovalStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'approval_flow_id' => 1,
                'step' => 1,
                'area_id' => Area::where('name', 'Pusat')->first()->id,
                'position_id' => Position::where('name', 'Kepala Logistik')->first()->id,
                'type_of_agreement' => 'Pemeriksa',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'approval_flow_id' => 1,
                'step' => 2,
                'area_id' => Area::where('name', 'Pusat')->first()->id,
                'position_id' => Position::where('name', 'Kepala Logistik')->first()->id,
                'type_of_agreement' => 'Pemberi Persetujuan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'approval_flow_id' => 2,
                'step' => 1,
                'area_id' => Area::where('name', 'Pusat')->first()->id,
                'position_id' => Position::where('name', 'Kepala Logistik')->first()->id,
                'type_of_agreement' => 'Pemeriksa',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'approval_flow_id' => 2,
                'step' => 2,
                'area_id' => Area::where('name', 'Pusat')->first()->id,
                'position_id' => Position::where('name', 'Kepala Logistik')->first()->id,
                'type_of_agreement' => 'Pemberi Persetujuan',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        ApprovalStep::insert($data);
    }
}
