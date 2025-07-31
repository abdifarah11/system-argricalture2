<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Crop;
use App\Models\Region;
use App\Models\Order; // Add this if you're linking to orders
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure crops, regions, and orders exist
        if (Crop::count() == 0 || Region::count() == 0 || Order::count() == 0) {
            \Log::warning('Seed crops, regions, and orders before running ReportSeeder.');
            return;
        }

        $crops = Crop::all();
        $regions = Region::all();
        $orders = Order::all();

        foreach (range(1, 20) as $i) {
            Report::create([
                'order_id'  => $orders->random()->id,
                'crop_id'   => $crops->random()->id,
                'region_id' => $regions->random()->id,
                'price'     => rand(10, 1000),
                'unit'      => ['kg', 'piece', 'litre'][array_rand(['kg', 'piece', 'litre'])],
                'quantity'  => rand(1, 100),
                'kg'        => rand(0, 50),
                'litre'     => rand(0, 50),
            ]);
        }
    }
}
