<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriptionSyncController extends Controller
{
    /**
     * Sync user subscription status from Flutter app (RevenueCat checkout).
     */
    public function sync(Request $request)
    {
        $fields = $request->validate([
            'plan' => 'required|string|in:free,standard,unlimited',
        ]);

        $user = $request->user();
        $oldPlan = $user->subscription_plan;
        $newPlan = $fields['plan'];

        if ($oldPlan !== $newPlan) {
            $user->update([
                'subscription_plan' => $newPlan,
            ]);

            Log::info("User #{$user->id} subscription synced via mobile to: {$newPlan}");

            try {
                $notificationService = app(\App\Services\NotificationService::class);
                $notificationService->notify(
                    $user,
                    'Subscription Synced',
                    'Your account subscription state has been synced to the ' . ucfirst($newPlan) . ' plan.',
                    'info'
                );
            } catch (\Exception $e) {
                Log::error('Failed to notify subscription sync: ' . $e->getMessage());
            }
        }

        return response()->json([
            'message' => 'Subscription status synced successfully',
            'subscription_plan' => $user->subscription_plan,
        ], 200);
    }
}
