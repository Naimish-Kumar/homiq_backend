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
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->nullable();
            $table->string('badge_icon')->nullable()->default('location_on');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->json('highlights')->nullable();
            $table->string('primary_cta_text')->default('Explore Projects');
            $table->string('primary_cta_link')->default('/#listings');
            $table->string('secondary_cta_text')->nullable()->default('Contact Us');
            $table->string('secondary_cta_link')->nullable()->default('javascript:void(0)');
            $table->string('secondary_cta_action')->default('request_modal');
            $table->string('image');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
