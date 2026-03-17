<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 // database/migrations/xxxx_xx_xx_create_orders_table.php
public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('order_number')->unique();
        $table->string('customer_name');
        $table->string('phone');
        $table->string('email');
        $table->string('district');
        $table->text('address');
        $table->json('items'); // Stores cart items [id, name, qty, price]
        $table->decimal('subtotal', 15, 2);
        $table->decimal('delivery_fee', 15, 2);
        $table->decimal('total', 15, 2);
        $table->string('status')->default('pending'); // pending, processing, delivered, cancelled
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
