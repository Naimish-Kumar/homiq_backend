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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('image')->nullable()->after('icon');
        });

        Schema::table('specifications', function (Blueprint $table) {
            $table->string('image')->nullable()->after('name');
        });

        Schema::table('key_features', function (Blueprint $table) {
            $table->string('image')->nullable()->after('name');
        });

        Schema::table('amenities', function (Blueprint $table) {
            $table->string('image')->nullable()->after('icon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('specifications', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('key_features', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('amenities', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
