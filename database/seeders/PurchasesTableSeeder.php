<?php

namespace Database\Seeders;
use DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('purchases')->insert([
            [
                'order_id' => 1,
                'crop_id' => 1,
                'quantity' => 10,
                'price_per_unit' => 25.50,
                'total_price' => 255.00,
            ],
        ]);
    }
}
