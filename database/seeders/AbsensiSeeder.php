<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Structure;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil semua employee_id dari tabel structures
        $employeeIds = Structure::pluck('employee_id')->toArray();

        foreach ($employeeIds as $employeeId) {
            // Generate 10 absensi untuk setiap employee_id
            for ($i = 0; $i < 10; $i++) {
                // Acak tanggal dalam bulan ini
                $randomDate = Carbon::now()->startOfMonth()->addDays(rand(0, Carbon::now()->daysInMonth - 1));

                // Acak jam check-in dan check-out, tetapi dengan kemungkinan untuk masuk dan pulang tepat waktu
                $isOnTime = rand(0, 1); // Untuk menentukan apakah masuk dan pulang tepat waktu (50% kemungkinan)

                if ($isOnTime) {
                    // Masuk dan pulang tepat waktu
                    $checkIn = Carbon::parse($randomDate->format('Y-m-d') . ' 08:00:00'); // Jam 8 pagi
                    $checkOut = Carbon::parse($checkIn)->addHours(9); // Jam 5 sore (9 jam kerja)
                } else {
                    // Masuk acak dan pulang acak (misalnya, lebih dari jam 8 dan pulang lebih dari jam 5 sore)
                    $checkIn = $faker->dateTimeThisMonth()->format('Y-m-d H:i:s');
                    $checkOut = Carbon::parse($checkIn)->addHours(rand(7, 9))->format('Y-m-d H:i:s');
                }

                // Masukkan data absensi ke tabel
                Absensi::create([
                    'employee_id' => $employeeId,
                    'date' => $randomDate->format('Y-m-d'),
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                ]);
            }
        }
    }
}
