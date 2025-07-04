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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
            $table->unsignedBigInteger('total_price');
            $table->unsignedBigInteger('shipping_cost');
            $table->unsignedBigInteger('total_bill');
            $table->string('shipping_courier')->nullable();
            $table->string('tracking_number')->nullable();
            $table->enum('status', ['Menunggu Pembayaran', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'])->default('Menunggu Pembayaran');
            $table->boolean('pickup_at_store')->default(false);
            $table->string('payment_status')->default('pending');
            $table->string('payment_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
