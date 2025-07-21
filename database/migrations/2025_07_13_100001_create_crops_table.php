<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();

            $table->unsignedBigInteger('crop_type_id');
            $table->foreign('crop_type_id')->references('id')->on('crop_types')->onDelete('cascade');

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('region_id')->nullable()->constrained();
            // $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crops');
    }
};
