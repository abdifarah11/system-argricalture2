<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('crop_id')->constrained();
            $table->unsignedBigInteger('crop_id');
            $table->foreign('crop_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreignId('region_id')->constrained();
            $table->decimal('price', 10, 2);
            $table->string('unit'); // e.g. kg, bag
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
