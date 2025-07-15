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
        Schema::create('price_history', function (Blueprint $table) {
            $table->id();

             // Define region_id as unsigned big integer
        $table->unsignedBigInteger('region_id');
        $table->foreign('region_id')
            ->references('id')
            ->on('regions')
            ->onDelete('cascade');

    $table->unsignedBigInteger('crop_id');

    $table->foreign('crop_id')
          ->references('id')
          ->on('crops')
            ->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->string('unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_history');
    }
};
