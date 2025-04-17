<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PermintaanMaterial>
 */
class PermintaanMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-2 years', 'now');

        return [
            'date' => $date,
            'ro_number' => 'RO-' . fake()->unique()->numerify('#######'),
            'employee_id' => 1,
            'area_id' => 1,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
