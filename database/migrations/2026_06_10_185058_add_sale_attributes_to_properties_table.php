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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('property_age')->nullable();
            $table->string('ownership_type')->nullable();
            $table->integer('built_up_area')->nullable();
            $table->boolean('is_negotiable')->default(false);
            $table->boolean('is_rera_approved')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'property_age',
                'ownership_type',
                'built_up_area',
                'is_negotiable',
                'is_rera_approved'
            ]);
        });
    }
};

