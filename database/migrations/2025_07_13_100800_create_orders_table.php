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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

                

            // $table->foreignId('crop_id')
            //     ->constrained('crops')
            //     ->onDelete('cascade');

            $table->foreignId('payment_method_id')
                ->nullable()
                ->constrained('payment_methods')
                ->onDelete('set null');

            $table->enum('status', [
                'pending',
                'incompleted',
                'confirmed',
                'cancelled',
                'completed'
            ])->default('pending')->index();

            $table->decimal('total_amount', 10, 2)
                ->default(0)
                ->comment('Total amount of the order');

            $table->text('description')->nullable();

            $table->timestamps();
        });

    }



    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
