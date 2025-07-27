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
      Schema::create('transactions', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
        ->constrained('users')
        ->onDelete('cascade');

    // $table->foreignId('crop_id')
    //     ->constrained('crops')
    //     ->onDelete('cascade');

    $table->foreignId('order_id')
        ->constrained('orders')
        ->onDelete('cascade');

    $table->foreignId('payment_method_id')
        ->nullable()
        ->constrained('payment_methods')
        ->onDelete('set null');

    $table->decimal('amount', 10, 2)
        ->comment('Transaction amount');

    $table->enum('status', [
        'pending', 'completed', 'failed', 'cancelled'
    ])->default('pending')->index();

    $table->text('description')->nullable();

    $table->timestamp('transaction_date')
        ->useCurrent()
        ->comment('Time the transaction occurred');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
