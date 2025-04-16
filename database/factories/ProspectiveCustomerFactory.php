<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Structure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProspectiveCustomer>
 */
class ProspectiveCustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $structure = Structure::inRandomOrder()->first();
        return [
            'date' => fake()->date('Y-m-d', 'now'),
            'identification_number' => fake()->unique()->numerify('##############'),
            'name' => str_replace("'", '', fake()->name()),
            'address' => str_replace("'", '', fake()->address()),
            'whatsapp_number' => '+62' . fake()->numerify('##########'),
            'email' => str_replace("'", '', fake()->unique()->safeEmail()),
            'employee_id' => $structure?->employee_id,
            'area_id' => $structure?->area_id,

        ];
    }
}
