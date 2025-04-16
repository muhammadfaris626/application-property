<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identification_number' => fake()->unique()->numerify('##############'),
            'name' => str_replace("'", '', fake()->name()),
            'address' => str_replace("'", '', fake()->address()),
            'place_of_birth' => str_replace("'", '', fake()->city()),
            'date_of_birth' => fake()->date('Y-m-d'),
            'whatsapp_number' => '+62' . fake()->numerify('##########'),
            'email' => str_replace("'", '', fake()->unique()->safeEmail()),
            'active' => 1
        ];
    }
}
