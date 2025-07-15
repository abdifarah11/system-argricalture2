<?php

namespace Database\Seeders;
use DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
            DB::table('prices')->insert([
            ['crop_id' => 1, 'region_id' => 1, 'price' => 25.50, 'unit' => 'kg'],
            ['crop_id' => 2, 'region_id' => 2, 'price' => 15.00, 'unit' => 'kg'],
        ]);
    }
}
