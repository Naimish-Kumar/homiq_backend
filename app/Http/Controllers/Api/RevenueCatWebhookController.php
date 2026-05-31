<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RevenueCatWebhookController extends Controller
{
    /**
     * Handle RevenueCat Webhook Events.
     */
    public function handleWebhook(Request $request)
    {
        // Optionally verify authorization token if set in RevenueCat settings
        $authHeader = $request->header('Authorization');
        Log::info('RevenueCat Webhook Received', ['headers' => $request->headers->all(), 'body' => $request->all()]);

        $event = $request->input('event');
        if (!$event) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $eventType = $event['type'] ?? '';
        $appUserId = $event['app_user_id'] ?? null;
        $entitlementIds = $event['entitlement_ids'] ?? [];

        if (!$appUserId) {
            return response()->json(['message' => 'No app_user_id provided'], 400);
        }

        $user = User::find($appUserId);
        if (!$user) {
            Log::warning("RevenueCat Webhook: User not found for app_user_id: {$appUserId}");
            return response()->json(['message' => 'User not found'], 404);
        }

        // Determine plan based on event type and active entitlements
        $newPlan = 'free';
        
        // If it's a purchase or renewal, map to standard or unlimited based on entitlements list
        if (in_array($eventType, ['INITIAL_PURCHASE', 'RENEWAL', 'UNCANCELLATION', 'TRANSFER'])) {
            if (in_array('unlimited', $entitlementIds)) {
                $newPlan = 'unlimited';
            } elseif (in_array('standard', $entitlementIds)) {
                $newPlan = 'standard';
            }
        } elseif (in_array($eventType, ['EXPIRATION', 'CANCELLATION', 'BILLING_ISSUE'])) {
            // Subscription lapsed, demote back to free
            $newPlan = 'free';
        } else {
            // For other events, we check if the user has any active entitlements in the list
            if (in_array('unlimited', $entitlementIds)) {
                $newPlan = 'unlimited';
            } elseif (in_array('standard', $entitlementIds)) {
                $newPlan = 'standard';
            }
        }

        $oldPlan = $user->subscription_plan;
        if ($oldPlan !== $newPlan) {
            $user->update([
                'subscription_plan' => $newPlan,
            ]);

            Log::info("User #{$user->id} subscription updated via RevenueCat Webhook (Event: {$eventType}) from {$oldPlan} to {$newPlan}");

            try {
                $notificationService = app(\App\Services\NotificationService::class);
                $notificationService->notify(
                    $user,
                    'Subscription Updated',
                    'Your account subscription tier has been updated to ' . ucfirst($newPlan) . ' via App Store/Google Play billing updates.',
                    'info'
                );
            } catch (\Exception $e) {
                Log::error('Failed to notify subscription webhook update: ' . $e->getMessage());
            }
        }

        return response()->json(['message' => 'Webhook processed successfully'], 200);
    }
}
