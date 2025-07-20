<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PriceHistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('price_history')->insert([
            [
                'crop_id'    => 1,
                'region_id'  => 1,
                'price'      => 22.00,
                'unit'       => 'kg',
                'quantity'   => 10,
                'kg'         => 10,
                'litre'      => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'crop_id'    => 2,
                'region_id'  => 2,
                'price'      => 45.75,
                'unit'       => 'litre',
                'quantity'   => 5,
                'kg'         => null,
                'litre'      => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'crop_id'    => 3,
                'region_id'  => 3,
                'price'      => 15.50,
                'unit'       => 'piece',
                'quantity'   => 20,
                'kg'         => null,
                'litre'      => 55,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
