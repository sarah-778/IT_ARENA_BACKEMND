<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::create('repairs', function (Blueprint $table) {
        $table->id();
        $table->string('type')->default('user'); 
        $table->string('tracking_code')->nullable()->unique(); // For tracking
        $table->string('status')->default('pending');         // For progress
        $table->string('name')->nullable();      
        $table->string('phone')->nullable();
        $table->string('email')->nullable();
        $table->string('device');
        $table->text('issue'); // Changed to text for longer descriptions
        $table->date('date')->nullable();        
        $table->string('image')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};