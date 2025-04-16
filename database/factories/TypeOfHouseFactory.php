<?php

namespace Database\Factories;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TypeOfHouse>
 */
class TypeOfHouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'area_id' => null,
            'code' => str_replace("'", '', $this->faker->unique()->bothify('TR-###')),
            'name' => str_replace("'", '', $this->faker->word() . ' House'),
            'price' => $this->faker->numberBetween(50000000, 500000000),

        ];
    }
}
