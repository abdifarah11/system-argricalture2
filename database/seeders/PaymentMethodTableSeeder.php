<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodTableSeeder extends Seeder
{
    public function run(): void
    {
        PaymentMethod::insert([
            [
                  'name' => 'Cash',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mobile Money',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bank Transfer',
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
         
        ]);
    }
}
