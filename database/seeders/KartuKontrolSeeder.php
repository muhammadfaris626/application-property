<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\KartuKontrol;
use App\Models\Pendapatan;
use App\Models\TypeOfHouse;
use App\Models\TypeOfIncome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KartuKontrolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();

        foreach ($customers as $customer) {
            KartuKontrol::factory()->create([
                'customer_id' => $customer->id,
            ]);
        }
    }
}
