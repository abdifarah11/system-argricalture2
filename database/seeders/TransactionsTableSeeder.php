<?php

namespace Database\Seeders;
use DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
           DB::table('transactions')->insert([
            [
                'user_id' => 1,
                'payment_id' => 1,
                'transaction_type' => 'debit',
                'amount' => 255.00,
                'description' => 'Purchase of 10kg maize',
            ],
        ]);
    }
}
