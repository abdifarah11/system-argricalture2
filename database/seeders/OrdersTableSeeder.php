<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'user_id' => 1,
                'crop_id' => 1,
                'payment_method_id' => 1,
                'status' => 'pending',
                'total_amount' => 150.50,
                'description' => 'First order - pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'crop_id' => 2,
                'payment_method_id' => 2,
                'status' => 'confirmed',
                'total_amount' => 320.75,
                'description' => 'Second order - confirmed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'crop_id' => 1,
                'payment_method_id' => 1,
                'status' => 'completed',
                'total_amount' => 199.99,
                'description' => 'Third order - completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
