<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RazorpayController extends Controller
{
    private Api $razorpayApi;

    public function __construct()
    {
        $keyId = config('services.razorpay.key_id') ?? env('RAZORPAY_KEY_ID');
        $keySecret = config('services.razorpay.key_secret') ?? env('RAZORPAY_KEY_SECRET');
        $this->razorpayApi = new Api($keyId, $keySecret);
    }

    /**
     * Create a Razorpay Order for subscription upgrade.
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:standard,unlimited',
        ]);

        $plan = $request->input('plan');
        $amount = $plan === 'standard' ? 499 : 999;

        try {
            $order = $this->razorpayApi->order->create([
                'receipt' => 'sub_rcpt_' . time() . '_' . Auth::id(),
                'amount' => $amount * 100, // Razorpay works in paise
                'currency' => 'INR',
                'notes' => [
                    'plan' => $plan,
                    'user_id' => Auth::id(),
                    'user_email' => Auth::user()->email,
                ]
            ]);

            return response()->json([
                'id' => $order['id'],
                'amount' => $order['amount'],
                'currency' => $order['currency'],
                'plan' => $plan,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Razorpay Order Creation Failed: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to create payment order. ' . $e->getMessage()], 500);
        }
    }

    /**
     * Verify the Razorpay Payment signature and update subscription plan.
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'plan' => 'required|in:standard,unlimited',
        ]);

        $orderId = $request->input('razorpay_order_id');
        $paymentId = $request->input('razorpay_payment_id');
        $signature = $request->input('razorpay_signature');
        $plan = $request->input('plan');

        $keySecret = config('services.razorpay.key_secret') ?? env('RAZORPAY_KEY_SECRET');

        // Verify the signature
        $expectedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $keySecret);

        if (hash_equals($expectedSignature, $signature)) {
            $user = Auth::user();
            $user->update([
                'subscription_plan' => $plan,
            ]);

            Log::info("User #{$user->id} upgraded successfully to {$plan} plan via Razorpay.");

            // Dispatch notification
            try {
                $notificationService = app(\App\Services\NotificationService::class);
                $notificationService->notify(
                    $user,
                    'Subscription Upgraded',
                    'Your account has been successfully upgraded to the ' . ucfirst($plan) . ' plan (₹' . ($plan === 'standard' ? '499' : '999') . '/month).',
                    'info'
                );
            } catch (\Exception $e) {
                Log::error('Failed to dispatch notification for upgraded user: ' . $e->getMessage());
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Subscription upgraded successfully.',
                    'plan' => $plan,
                ], 200);
            }

            return redirect('/dashboard')->with('success', 'Your subscription has been successfully upgraded to ' . ucfirst($plan) . '!');
        }

        Log::error('Razorpay Signature Verification Failed', [
            'order_id' => $orderId,
            'payment_id' => $paymentId,
            'signature' => $signature
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['message' => 'Payment signature verification failed.'], 400);
        }

        return redirect('/pricing')->withErrors(['error' => 'Payment signature verification failed. Please try again.']);
    }
}
