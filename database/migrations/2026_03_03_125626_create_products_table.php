<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // Phones, Laptops, etc.
            $table->string('brand');    // Apple, Samsung, Dell, etc.
            $table->decimal('price', 15, 2); 
            $table->integer('stock')->default(0);
            $table->boolean('isOEM')->default(true); // Genuine flag
            $table->string('warranty')->default('6 Months');
            $table->longText('image')->nullable(); // Changed to longText for Base64 photos
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};