<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\ListPurchaseOfMaterial;
use App\Models\Material;
use App\Models\PurchaseOfMaterial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseOfMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            PurchaseOfMaterial::factory()
                ->count(5)
                ->create(['employee_id' => $employee->id])
                ->each(function ($purchase) {
                    $materials = Material::inRandomOrder()->take(3)->get();
                    foreach ($materials as $material) {
                        $quantity = rand(1, 100);
                        $price = fake()->randomFloat(2, 1000, 10000);

                        ListPurchaseOfMaterial::create([
                            'purchase_of_material_id' => $purchase->id,
                            'material_id' => $material->id,
                            'quantity' => $quantity,
                            'price' => $price,
                            'total_price' => $quantity * $price,
                            'created_at' => $purchase->created_at,
                            'updated_at' => $purchase->updated_at,
                        ]);
                    }
                });
        }
    }
}
