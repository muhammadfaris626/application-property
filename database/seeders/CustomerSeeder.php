<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\ProspectiveCustomer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            $prospects = ProspectiveCustomer::where('employee_id', $employee->id)->inRandomOrder()->take(2)->get();

            foreach ($prospects as $prospect) {
                Customer::factory()->create([
                    'prospective_customer_id' => $prospect->id,
                    'employee_id' => $employee->id,
                ]);
            }
        }
        // $data = [
        //     [
        //         'tanggal'                 => '2025-04-08',
        //         'nomor_berkas'            => 'BERKAS123',
        //         'prospective_customer_id' => 1,
        //         'type_of_house_id'        => 1,
        //         'keterangan_rumah'        => 'Blok A Nomor 7',
        //         'status_penjualan'        => 'KREDIT TAPERA',
        //         'status_pengajuan_user'   => 'SPR',
        //         'verifikasi_dp'           => 1,
        //         'upload_berkas'           => 'berkas-customer/berkas_20250408_032646.pdf',
        //         'employee_id'             => 2,
        //         'created_at'              => now(),
        //         'updated_at'              => now()
        //     ]
        // ];

        // Customer::insert($data);
    }
}
