<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Orders table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['Pending', 'Processing', 'Delivered'])->default('Pending');
            $table->text('shipping_address');
            $table->timestamps();

            $table->index('status');
            $table->index('user_id');
        });

        // Order_Items bridge table — resolves Many-to-Many between Plants and Orders
        // price_at_purchase locks the price so future price changes don't affect old orders
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('plant_id')->constrained('plants')->onDelete('restrict');
            $table->unsignedInteger('quantity');
            $table->decimal('price_at_purchase', 8, 2); // Historical price snapshot
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
