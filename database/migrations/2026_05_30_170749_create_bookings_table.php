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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->foreignId('renter_id')->constrained('users')->cascadeOnDelete();
            $table->date('check_in');
            $table->date('check_out');
            $table->decimal('base_rent', 10, 2);
            $table->decimal('taxes', 10, 2);
            $table->decimal('platform_fee', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending'); // pending, approved, rejected, cancelled, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
