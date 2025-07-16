<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PriceTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prices')->insert([
            [
                'crop_id' => 1,
                'region_id' => 1,
                'kg' => 10,
                'litre' => 21,
                'price' => 50,
                'quantity' => 10,
                'unit' => 'kg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'crop_id' => 2,
                'region_id' => 2,
                'kg' => 0,
                'litre' => 12,
                'price' => 30.5,
                'quantity' => 5,
                'unit' => 'piece',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'crop_id' => 3,
                'region_id' => 3,
                'kg' => 33,
                'litre' => 15,
                'price' => 20.75,
                'quantity' => 15,
                'unit' => 'litre',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
