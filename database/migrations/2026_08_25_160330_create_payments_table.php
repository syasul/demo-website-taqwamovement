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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('gateway'); // e.g. midtrans, xendit
            $table->string('gateway_transaction_id')->nullable();
            $table->string('payment_method')->nullable(); // e.g. bank_transfer, qris, gopay
            $table->decimal('amount', 15, 2);
            $table->string('status'); // e.g. pending, settlement, expire, cancel
            $table->json('raw_payload')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
