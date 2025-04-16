<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\TypeOfHouse;
use App\Models\TypeOfIncome;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KartuKontrol>
 */
class KartuKontrolFactory extends Factory
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
            'customer_id' => $customer?->id,
            'sbum' => $this->faker->boolean(70) ? 1 : null,
            'dp' => $this->faker->boolean(70) ? 1 : null,
            'imb' => $this->faker->boolean(70) ? 1 : null,
            'sertifikat' => $this->faker->boolean(70) ? 1 : null,
            'jkk' => $this->faker->boolean(70) ? 1 : null,
            'listrik' => $this->faker->boolean(70) ? 1 : null,
            'bestek' => $this->faker->boolean(70) ? 1 : null,
            'created_at' => $randomDate,
            'updated_at' => $randomDate,
        ];
    }
}
