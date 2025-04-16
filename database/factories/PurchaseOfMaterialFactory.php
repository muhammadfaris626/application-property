<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseOfMaterial>
 */
class PurchaseOfMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startYear = Carbon::now()->subYears(2)->startOfYear(); // 2 tahun lalu, awal tahun
        $endYear = Carbon::now()->endOfYear(); // akhir tahun sekarang
        $randomDate = $this->faker->dateTimeBetween($startYear, $endYear);

        return [
            'invoice_number' => fake()->unique()->numerify('INV-#####'),
            'date' => $randomDate->format('Y-m-d'),
            'supplier_id' => Supplier::inRandomOrder()->first()?->id ?? Supplier::factory(),
            'employee_id' => Employee::inRandomOrder()->first()?->id ?? Employee::factory(),
            'created_at' => $randomDate,
            'updated_at' => $randomDate,
        ];
    }
}
