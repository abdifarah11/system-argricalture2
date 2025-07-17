<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transactions')->insert([
            [
                'user_id'           => 1,
                'crop_id'           => 1,
                'order_id'          => 1,
                'payment_method_id' => 1,
                'amount'            => 150.50,
                'status'            => 'pending',
                'description'       => 'Transaction for order #1',
                'transaction_date'  => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'user_id'           => 2,
                'crop_id'           => 2,
                'order_id'          => 2,
                'payment_method_id' => 2,
                'amount'            => 320.75,
                'status'            => 'completed',
                'description'       => 'Transaction for order #2',
                'transaction_date'  => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'user_id'           => 1,
                'crop_id'           => 1,
                'order_id'          => 1,
                'payment_method_id' => 1,
                'amount'            => 199.99,
                'status'            => 'failed',
                'description'       => 'Transaction for order #3',
                'transaction_date'  => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);
    }
}
