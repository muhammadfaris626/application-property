<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Dummy Data
            AreaSeeder::class,
            PositionSeeder::class,
            EmployeeSeeder::class,
            MaterialCategorySeeder::class,
            TypeOfExpenditureSeeder::class,
            TypeOfIncomeSeeder::class,
            StructureSeeder::class,
            UserSeeder::class,
            MaterialSeeder::class,
            SupplierSeeder::class,
            TypeOfHouseSeeder::class,
            PurchaseOfMaterialSeeder::class,
            KasBesarSeeder::class,
            KasKecilSeeder::class,
            ProspectiveCustomerSeeder::class,
            CustomerSeeder::class,
            KartuKontrolSeeder::class,
            PendapatanSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            AllSeeder::class,
            ApprovalFlowSeeder::class,
            ApprovalStepSeeder::class,
            PermintaanMaterialSeeder::class


            // AllDataSeeder::class,
            // RoleSeeder::class,
            // PermissionSeeder::class

        ]);
    }
}
