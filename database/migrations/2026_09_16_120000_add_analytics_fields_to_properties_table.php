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
            $table->unsignedBigInteger('views_count')->default(0)->after('status');
            $table->unsignedBigInteger('impressions_count')->default(0)->after('views_count');
            $table->unsignedBigInteger('inquiries_count')->default(0)->after('impressions_count');
            $table->unsignedBigInteger('whatsapp_clicks')->default(0)->after('inquiries_count');
            $table->unsignedBigInteger('saves_count')->default(0)->after('whatsapp_clicks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'views_count',
                'impressions_count',
                'inquiries_count',
                'whatsapp_clicks',
                'saves_count',
            ]);
        });
    }
};

