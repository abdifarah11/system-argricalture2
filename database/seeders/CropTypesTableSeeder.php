<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CropTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('crop_types')->insert([
            [
                'name' => 'Cereal',
                'description' => 'Wheat, maize, rice, etc.',
                'image' => 'crop_types/cereal.jpg', // You can replace with actual image
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vegetable',
                'description' => 'Onions, tomatoes, spinach.',
                'image' => 'crop_types/vegetable.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fruit',
                'description' => 'Bananas, mangoes, papayas.',
                'image' => 'crop_types/fruit.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
