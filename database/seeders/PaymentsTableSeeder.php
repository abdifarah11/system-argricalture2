<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
          DB::table('payments')->insert([
            [
                'order_id' => 1,
                'amount' => 255.00,
                'payment_method' => 'mobile_money',
                'payment_status' => 'paid',
                'paid_at' => Carbon::now(),
            ],
        ]);
    }
}
