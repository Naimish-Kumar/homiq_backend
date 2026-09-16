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
        Schema::create('property_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('seeker_name');
            $table->string('seeker_phone');
            $table->string('seeker_email')->nullable();
            $table->string('city');
            $table->string('locality')->nullable();
            $table->string('property_type')->default('Apartment'); // Apartment, Villa, Studio, PG, House, Commercial
            $table->string('bedrooms')->nullable(); // 1 BHK, 2 BHK, 3+ BHK, Room
            $table->decimal('min_budget', 12, 2)->nullable();
            $table->decimal('max_budget', 12, 2);
            $table->string('purpose')->default('rent'); // rent, buy
            $table->string('move_in_date')->nullable(); // Immediate, Within 15 days, Next month
            $table->text('description')->nullable();
            $table->string('status')->default('active'); // active, fulfilled, closed
            $table->integer('responses_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_requests');
    }
};

