<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\TypeOfIncome;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pendapatan>
 */
class PendapatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = Customer::inRandomOrder()->first();
        $randomDate = $this->faker->dateTimeBetween(now()->subYears(2), now());

        return [
            'tanggal' => $randomDate->format('Y-m-d'),
            'type_of_income_id' => TypeOfIncome::inRandomOrder()->value('id'),
            'customer_id' => $customer?->id,
            'keterangan' => $this->faker->sentence(3),
            'total' => $this->faker->numberBetween(1000000, 20000000),
            'employee_id' => $customer?->employee_id,
            'created_at' => $randomDate,
            'updated_at' => $randomDate,
        ];
    }
}
