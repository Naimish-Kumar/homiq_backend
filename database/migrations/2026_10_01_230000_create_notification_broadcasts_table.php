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
        Schema::create('notification_broadcasts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->string('target_audience')->default('all'); // all, hosts, tenants, pro, business, individual
            $table->foreignId('target_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('type')->default('announcement'); // announcement, promotion, alert, system, info
            $table->string('action_url')->nullable();
            $table->integer('recipients_count')->default(0);
            $table->integer('fcm_sent_count')->default(0);
            $table->foreignId('sent_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default('sent'); // sent, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_broadcasts');
    }
};
