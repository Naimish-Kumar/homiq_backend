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
        // 1. Add fields to properties table
        Schema::table('properties', function (Blueprint $table) {
            $table->boolean('supports_group_renting')->default(false);
            $table->integer('group_max_size')->default(3);
        });

        // 2. Create roommate_groups table
        Schema::create('roommate_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->string('status')->default('searching'); // searching, ready, booked, cancelled
            $table->integer('max_roommates')->default(3);
            $table->timestamps();
        });

        // 3. Create roommate_group_members table
        Schema::create('roommate_group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roommate_group_id')->constrained('roommate_groups')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['roommate_group_id', 'user_id']);
        });

        // 4. Add roommate_group_id to bookings table
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('roommate_group_id')->nullable()->constrained('roommate_groups')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['roommate_group_id']);
            $table->dropColumn('roommate_group_id');
        });

        Schema::dropIfExists('roommate_group_members');
        Schema::dropIfExists('roommate_groups');

        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['supports_group_renting', 'group_max_size']);
        });
    }
};
