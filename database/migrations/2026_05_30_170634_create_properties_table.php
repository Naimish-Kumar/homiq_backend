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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('address');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->json('amenities')->nullable();
            $table->json('images')->nullable();
            $table->string('category');
            $table->integer('bedrooms')->default(0);
            $table->integer('bathrooms')->default(0);
            $table->boolean('is_furnished')->default(false);
            $table->boolean('has_parking')->default(false);
            $table->boolean('is_pet_friendly')->default(false);
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
