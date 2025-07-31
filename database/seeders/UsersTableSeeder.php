<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Delete existing users safely without truncate to avoid foreign key errors
        DB::table('users')->delete();

        // Reset auto-increment counter (optional)
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');

        DB::table('users')->insert([
            [
                'fullname'   => 'Farah Hassan',
                'email'      => 'farah@gmail.com',
                'phone'      => '611232323',
                'password'   => Hash::make('12345678'),
                'role'       => 'admin',
                'region_id'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname'   => 'abdi',
                'email'      => 'farmer@gmail.com',
                'phone'      => '611232323',
                'password'   => Hash::make('12345678'),
                'role'       => 'market_officer',
                'region_id'  => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname'   => 'Buyer Ahmed',
                'email'      => 'buyer@gmail.com',
                'phone'      => '611232323',
                'password'   => Hash::make('12345678'),
                'role'       => 'general',
                'region_id'  => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname'   => 'customer Ahmed',
                'email'      => 'customer@gmail.com',
                'phone'      => '611232323',
                'password'   => Hash::make('12345678'),
                'role'       => 'customer',
                'region_id'  => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
