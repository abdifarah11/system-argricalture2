<?php

namespace Database\Seeders;
use DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
       DB::table('regions')->insert([
    ['name' => 'Awdal'],
    ['name' => 'Bakool'],
    ['name' => 'Banadir'],
    ['name' => 'Bari'],
    ['name' => 'Bay'],
    ['name' => 'Galgaduud'],
    ['name' => 'Gedo'],
    ['name' => 'Hiiraan'],
    ['name' => 'Lower Juba'],
    ['name' => 'Middle Juba'],
    ['name' => 'Lower Shabelle'],
    ['name' => 'Middle Shabelle'],
    ['name' => 'Mudug'],
    ['name' => 'Nugal'],
    ['name' => 'Sanaag'],
    ['name' => 'Sool'],
    ['name' => 'Togdheer'],
    ['name' => 'Woqooyi Galbeed']
]);

    }
}
