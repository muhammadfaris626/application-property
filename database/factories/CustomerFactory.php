<?php

namespace Database\Factories;

use App\Models\ProspectiveCustomer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil satu prospective_customer secara acak
        $prospect = ProspectiveCustomer::inRandomOrder()->first();
        $employeeId = $prospect?->employee_id;

        // Buat tanggal acak 3 tahun terakhir
        $randomDate = $this->faker->dateTimeBetween(now()->subYears(2), now());

        // Buat upload_berkas dari tanggal acak
        $fileTimestamp = Carbon::parse($randomDate)->format('Ymd_His');
        $uploadBerkas = "berkas-customer/berkas_{$fileTimestamp}.pdf";

        // Buat keterangan rumah acak
        $blok = chr(rand(65, 90)); // A-Z
        $nomor = rand(1, 30);
        $keteranganRumah = "Blok {$blok} Nomor {$nomor}";

        $statusPengajuan = $this->faker->randomElement(['SPR', 'SP3K', 'AKAD']);

        return [
            'tanggal' => $randomDate->format('Y-m-d'),
            'nomor_berkas' => strtoupper(str_replace("'", '', $this->faker->bothify('CU####'))),
            'prospective_customer_id' => $prospect?->id,
            'type_of_house_id' => rand(1, 5),
            'keterangan_rumah' => str_replace("'", '', $keteranganRumah),
            'status_penjualan' => str_replace("'", '', $this->faker->randomElement(['KREDIT FLPP', 'KREDIT TAPERA', 'CASH'])),
            'status_pengajuan_user' => str_replace("'", '', $statusPengajuan),
            'verifikasi_dp' => $statusPengajuan === 'SPR' ? 1 : null,
            'upload_berkas' => str_replace("'", '', $uploadBerkas),
            'employee_id' => $employeeId,
            'created_at' => $randomDate,
            'updated_at' => $randomDate,
        ];
    }
}
