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
            $table->integer('phone')->nullable();
            $table->string('location')->nullable();   
            $table->string('email')->nullable();      
            $table->string('url')->nullable();        
            $table->string('logo_path')->nullable(); 
            $table->string('address')->nullable();    
            $table->string('whatsapp')->nullable();  

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
}
