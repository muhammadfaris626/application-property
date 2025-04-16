<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Structure>
 */
class StructureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $usedEmployees = []; // Menyimpan ID yang sudah digunakan

        // Ambil employee yang belum digunakan
        $employee = Employee::whereNotIn('id', $usedEmployees)
            ->inRandomOrder()
            ->first();

        // Jika semua employee sudah terpakai, buat yang baru
        if (!$employee) {
            $employee = Employee::factory()->create();
        }

        // Simpan ID ke dalam array agar tidak terpakai lagi
        $usedEmployees[] = $employee->id;

        return [
            'employee_id' => $employee->id,
            'position_id' => Position::query()->inRandomOrder()->value('id') ?? Position::factory(),
            'area_id' => Area::query()->inRandomOrder()->value('id') ?? Area::factory(),
            'employee_number' => fake()->unique()->numerify('##########'),
        ];
    }
}
