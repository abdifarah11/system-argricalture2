<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
   DB::table('users')->insert([
    [
        'fullname'       => 'Farah Hassan',          // or use 'fullname' if that’s your column
        'username'   => 'farah',
        'email'      => 'farah@gmail.com',
        'password'   => Hash::make('12345678'),
        'user_type'  => 'admin',
        'region_id'  => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'fullname'       => 'Farmer Ahmed',
        'username'   => 'farmer',
        'email'      => 'farmer@example.com',
        'password'   => Hash::make('password'),
        'user_type'  => 'market_officer',
        'region_id'  => 2,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'fullname'       => 'Buyer Ahmed',
        'username'   => 'jiisow',
        'email'      => 'buyer@example.com',
        'password'   => Hash::make('password'),
        'user_type'  => 'general',
        'region_id'  => 3,
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);

    }
}
