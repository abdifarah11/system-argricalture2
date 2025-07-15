<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceHistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         DB::table('price_history')->insert([
            ['crop_id' => 1, 'region_id' => 1, 'price' => 22.00, 'unit' => 'kg'],
            ['crop_id' => 1, 'region_id' => 1, 'price' => 23.50, 'unit' => 'kg'],
        ]);
    }
}
