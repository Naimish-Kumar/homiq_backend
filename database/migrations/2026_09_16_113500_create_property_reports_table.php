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
        Schema::create('property_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reporter_name')->nullable();
            $table->string('reporter_contact')->nullable();
            $table->string('reason'); // fake_property, incorrect_price, wrong_location, duplicate_listing, misleading_photos, owner_not_responding, already_rented_sold, suspicious_activity
            $table->text('details')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('status')->default('pending'); // pending, reviewed, dismissed, resolved
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_reports');
    }
};

