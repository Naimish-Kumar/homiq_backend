<?php

namespace App\Services;

use App\Models\User;
use App\Models\Property;
use App\Models\ReferralTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReferralService
{
    const SIGNUP_REWARD = 5.00;
    const PROPERTY_REWARD = 20.00;
    const MINIMUM_WITHDRAWAL = 50.00;

    /**
     * Process referral bonus for a new user signup.
     */
    public function rewardSignup(User $newUser, User $referrer): void
    {
        try {
            DB::transaction(function () use ($newUser, $referrer) {
                // Credit ₹5.00 to referrer
                $referrer->increment('referral_balance', self::SIGNUP_REWARD);
                $referrer->increment('total_referral_earned', self::SIGNUP_REWARD);

                // Create ledger transaction
                ReferralTransaction::create([
                    'user_id' => $referrer->id,
                    'amount' => self::SIGNUP_REWARD,
                    'type' => 'signup_bonus',
                    'description' => "Referral Bonus: {$newUser->name} signed up with your code",
                    'source_user_id' => $newUser->id,
                    'status' => 'completed',
                ]);
            });

            // Dispatch notification
            try {
                $notificationService = app(NotificationService::class);
                $notificationService->notify(
                    $referrer,
                    'Referral Reward: ₹5 Credited! 🎉',
                    "{$newUser->name} registered using your referral code. ₹5.00 has been credited to your referral wallet!",
                    'success'
                );
            } catch (\Exception $ne) {
                Log::warning("Notification to referrer failed: " . $ne->getMessage());
            }
        } catch (\Exception $e) {
            Log::error("Failed to process signup referral reward: " . $e->getMessage());
        }
    }

    /**
     * Process referral bonus when a referred user publishes a property.
     */
    public function rewardPropertyAdded(Property $property): void
    {
        try {
            $owner = $property->owner;
            if (!$owner || empty($owner->referred_by_id)) {
                return;
            }

            $referrer = User::find($owner->referred_by_id);
            if (!$referrer) {
                return;
            }

            DB::transaction(function () use ($property, $owner, $referrer) {
                // Credit ₹20.00 to referrer
                $referrer->increment('referral_balance', self::PROPERTY_REWARD);
                $referrer->increment('total_referral_earned', self::PROPERTY_REWARD);

                // Create ledger transaction
                ReferralTransaction::create([
                    'user_id' => $referrer->id,
                    'amount' => self::PROPERTY_REWARD,
                    'type' => 'property_bonus',
                    'description' => "Property Referral Bonus: {$owner->name} published '{$property->title}'",
                    'source_user_id' => $owner->id,
                    'property_id' => $property->id,
                    'status' => 'completed',
                ]);
            });

            // Dispatch notification
            try {
                $notificationService = app(NotificationService::class);
                $notificationService->notify(
                    $referrer,
                    'Property Reward: ₹20 Credited! 🏠',
                    "{$owner->name} added a new property '{$property->title}'. ₹20.00 has been credited to your referral wallet!",
                    'success'
                );
            } catch (\Exception $ne) {
                Log::warning("Notification to referrer for property failed: " . $ne->getMessage());
            }
        } catch (\Exception $e) {
            Log::error("Failed to process property referral reward: " . $e->getMessage());
        }
    }
}
