<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Crop;
use App\Models\Region;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        // Make sure there are crops and regions first
        if (Crop::count() == 0 || Region::count() == 0) {
            \Log::warning('Please seed crops and regions before reports.');
            return;
        }

        $crops = Crop::all();
        $regions = Region::all();

        foreach (range(1, 20) as $i) {
            Report::create([
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
