<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('reports', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('crop_id');
    $table->foreign('crop_id')->references('id')->on('crops')->onDelete('cascade');
     $table->foreignId('order_id')
        ->constrained('orders')
        ->onDelete('cascade');

    $table->foreignId('region_id')->constrained(); // Automatically references regions.id
    $table->decimal('price', 10, 2);
    $table->enum('unit', ['kg', 'piece', 'litre']);
    $table->integer('quantity')->nullable();
    $table->integer('kg')->nullable();
    $table->integer('litre')->nullable();
    
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
