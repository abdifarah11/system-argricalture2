<?php 


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'system_name' => 'Web Platform for Real-Time Agricultural Prices',
            'phone' => '616870101',
            'location' => 'https://www.google.com/maps/place/Jaamacada+Jamhuuriya',
            'email' => 'mailto:abdirahmanfarah1164@gmail.com',
            'url' => 'http://127.0.0.1:8000/home',
            'logo_path' => 'public/img/logo.jpg', // add logo path if you have one
            
            // ✅ New fields
            'address' => 'Afgooye ,street,,hoden, Mogadishu, Somalia',
            'whatsapp' => 'https://wa.me/252616870101', // WhatsApp international format
        ]);
    }
}

