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
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('delivery_method', ['delivery', 'pickup'])->default('delivery');
            $table->foreignId('address_id')->nullable()->constrained('addresses')->onDelete('set null');
            $table->enum('status', [
                'cancelled',
                'awaiting_payment',
                'pending',
                'processed',
                'ready_for_pickup',
                'shipped',
                'completed'
            ])->default('awaiting_payment');
            $table->unsignedInteger('total_amount');
            $table->unsignedInteger('shipping_cost')->default(0);
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
