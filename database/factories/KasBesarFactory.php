<?php

namespace Database\Factories;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KasBesar>
 */
class KasBesarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startYear = Carbon::now()->subYears(2)->startOfYear();
        $endYear = Carbon::now()->endOfYear();
        $randomDate = fake()->dateTimeBetween($startYear, $endYear);
        return [
            'category' => fake()->randomElement(['Pemasukan', 'Pengeluaran']),
            'date' => $randomDate->format('Y-m-d'),
            'employee_id' => Employee::inRandomOrder()->first()?->id ?? Employee::factory(),
            'created_at' => $randomDate,
            'updated_at' => $randomDate,
        ];
    }
}
