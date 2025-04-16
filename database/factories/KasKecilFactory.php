<?php

namespace Database\Factories;

use App\Models\Structure;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KasKecil>
 */
class KasKecilFactory extends Factory
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
        $randomDate = $this->faker->dateTimeBetween($startYear, $endYear);

        // ambil struktur random
        $structure = Structure::inRandomOrder()->first();
        return [
            'category' => $this->faker->randomElement(['Pemasukan', 'Pengeluaran']),
            'date' => $randomDate->format('Y-m-d'),
            'employee_id' => $structure?->employee_id,
            'area_id' => $structure?->area_id,
            'created_at' => $randomDate,
            'updated_at' => $randomDate,
        ];
    }
}
