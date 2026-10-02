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
        // 1. Add referral balance tracking to users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'referral_balance')) {
                $table->decimal('referral_balance', 10, 2)->default(0.00)->after('subscription_plan');
            }
            if (!Schema::hasColumn('users', 'total_referral_earned')) {
                $table->decimal('total_referral_earned', 10, 2)->default(0.00)->after('referral_balance');
            }
        });

        // 2. Create withdrawal requests table
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('payout_method'); // 'upi' or 'bank'
            $table->string('upi_id')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('status')->default('pending'); // 'pending', 'approved', 'rejected'
            $table->string('transaction_reference')->nullable(); // UTR / Reference ID
            $table->text('admin_notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });

        // 3. Create referral transactions ledger table
        Schema::create('referral_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('type'); // 'signup_bonus', 'property_bonus', 'withdrawal', 'refund', 'adjustment'
            $table->string('description');
            $table->foreignId('source_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('property_id')->nullable()->constrained('properties')->onDelete('set null');
            $table->foreignId('withdrawal_request_id')->nullable()->constrained('withdrawal_requests')->onDelete('set null');
            $table->string('status')->default('completed'); // 'completed', 'pending', 'rejected'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_transactions');
        Schema::dropIfExists('withdrawal_requests');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['referral_balance', 'total_referral_earned']);
        });
    }
};
