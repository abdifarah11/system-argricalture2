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
                'buyer_id' => 1,
                'status' => 'pending',
                'total_amount' => 150.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'buyer_id' => 1,
                'status' => 'confirmed',
                'total_amount' => 320.75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'buyer_id' => 1,
                'status' => 'completed',
                'total_amount' => 199.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


