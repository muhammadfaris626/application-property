<?php

namespace Database\Seeders;

use App\Models\ApprovalFlow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApprovalFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Persetujuan Permintaan Material',
                'model_type' => 'App\Models\PermintaanMaterial',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Persetujuan Pengajuan Invoice',
                'model_type' => 'App\Models\PengajuanInvoice',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        ApprovalFlow::insert($data);
    }
}
