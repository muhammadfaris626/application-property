<?php

namespace Database\Seeders;

use App\Models\ProspectiveCustomer;
use App\Models\Structure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProspectiveCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $structures = Structure::all();

        foreach ($structures as $structure) {
            for ($i=0; $i < 5; $i++) {
                $prospective = ProspectiveCustomer::factory()->create([
                    'employee_id' => $structure->employee_id,
                    'area_id' => $structure->area_id,
                ]);
            }
        }

        // $data = [
        //     [
        //         'date'                  => '2025-04-07',
        //         'identification_number' => '737114050750009',
        //         'name'                  => 'Firman',
        //         'address'               => 'Jalan urip sumohardjo',
        //         'whatsapp_number'       => '+628123456789',
        //         'email'                 => 'firman@gmail.com',
        //         'employee_id'           => 3,
        //         'area_id'               => 2,
        //         'created_at'            => now(),
        //         'updated_at'            => now()
        //     ]
        // ];
        // ProspectiveCustomer::insert($data);
    }
}
