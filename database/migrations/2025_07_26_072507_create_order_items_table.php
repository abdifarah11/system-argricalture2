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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // references 'id' on 'orders'
            $table->foreignId('crop_id')->constrained()->onDelete('cascade'); // references 'id' on 'crops'

            $table->string('name'); // To preserve name at time of order
            $table->string('image')->nullable(); // Optional: image path
            $table->decimal('price', 10, 2); // Price at the time of order
            $table->integer('quantity');
            $table->decimal('total', 10, 2); // price * quantity

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
