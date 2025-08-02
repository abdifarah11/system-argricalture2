<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Crop;
use App\Models\Region;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        if (Crop::count() == 0 || Region::count() == 0 || Order::count() == 0) {
            \Log::warning('Seed crops, regions, and orders before running ReportSeeder.');
            return;
        }

        foreach (range(1,2) as $i) {
            $reports = [
                [
                    'order_id' => 1,
                    'crop_id' => 1,
                    'region_id' => 1,
                    'kg' => 12,
                    'litre' => 0,
                    'price' => 150.00,
                    'quantity' => 10,
                    'unit' => 'kg',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
             
                [
                    'order_id' => 3,
                    'crop_id' => 2,
                    'region_id' => 3,
                    'kg' => 0,
                    'litre' => 20,
                    'price' => 90.00,
                    'quantity' => 15,
                    'unit' => 'litre',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ];

            // Insert multiple records at once
            Report::insert($reports);
        }
    }
}
