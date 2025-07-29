<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('system_name');
            $table->string('phone')->nullable();
            $table->string('location')->nullable();   // Google Maps link
            $table->string('email')->nullable();      // mailto: link
            $table->string('url')->nullable();        // System homepage URL
            $table->string('logo_path')->nullable();  // Path to logo (e.g., public/img/logo.jpg)

            // ✅ Newly added fields
            $table->string('address')->nullable();    // Physical address
            $table->string('whatsapp')->nullable();   // WhatsApp contact link

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
}
