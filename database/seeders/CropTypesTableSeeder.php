<?php

namespace Database\Seeders;
use DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Vegetable',
        'description' => 'Onions, tomatoes, spinach.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Fruit',
        'description' => 'Bananas, mangoes, papayas.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);

    }
}
