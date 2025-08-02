<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PaymentMethodSeeder;


class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // User::factory(10)->create();
    $this->call([
      RegionsTableSeeder::class,
      UsersTableSeeder::class,
      CropTypesTableSeeder::class,
      CropsTableSeeder::class,
      PriceTableSeeder::class,
      PaymentMethodTableSeeder::class,
      OrdersTableSeeder::class,
      ReportSeeder::class,

        // PurchasesTableSeeder::class,
        //  PaymentsTableSeeder::class,
      TransactionsTableSeeder::class,
      SettingSeeder::class,

    ]);


  }
}
