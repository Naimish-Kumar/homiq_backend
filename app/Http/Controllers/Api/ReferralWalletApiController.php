<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReferralTransaction;
use App\Models\WithdrawalRequest;
use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReferralWalletApiController extends Controller
{
    /**
     * Get user's referral balance, earnings, stats, and transaction history.
     */
    public function getWallet(Request $request)
    {
        $user = $request->user()->fresh();

        $transactions = ReferralTransaction::where('user_id', $user->id)
            ->with(['sourceUser:id,name,email', 'property:id,title'])
            ->latest()
            ->take(50)
            ->get();

        $withdrawals = WithdrawalRequest::where('user_id', $user->id)
            ->latest()
            ->take(50)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'referral_code' => $user->referral_code,
                'referral_balance' => (float) ($user->referral_balance ?? 0),
                'total_referral_earned' => (float) ($user->total_referral_earned ?? 0),
                'referrals_count' => $user->referrals_count,
                'minimum_withdrawal' => ReferralService::MINIMUM_WITHDRAWAL,
                'reward_rules' => [
                    'signup_reward' => ReferralService::SIGNUP_REWARD,
                    'property_reward' => ReferralService::PROPERTY_REWARD,
                ],
                'transactions' => $transactions->map(function ($t) {
                    return [
                        'id' => $t->id,
                        'amount' => (float) $t->amount,
                        'type' => $t->type,
                        'description' => $t->description,
                        'status' => $t->status,
                        'source_user_name' => $t->sourceUser?->name,
                        'property_title' => $t->property?->title,
                        'created_at' => $t->created_at?->toIso8601String(),
                    ];
                }),
                'withdrawals' => $withdrawals->map(function ($w) {
                    return [
                        'id' => $w->id,
                        'amount' => (float) $w->amount,
                        'payout_method' => $w->payout_method,
                        'upi_id' => $w->upi_id,
                        'account_holder_name' => $w->account_holder_name,
                        'account_number' => $w->account_number ? (strlen($w->account_number) > 4 ? '••••' . substr($w->account_number, -4) : $w->account_number) : null,
                        'ifsc_code' => $w->ifsc_code,
                        'bank_name' => $w->bank_name,
                        'status' => $w->status,
                        'transaction_reference' => $w->transaction_reference,
                        'admin_notes' => $w->admin_notes,
                        'processed_at' => $w->processed_at?->toIso8601String(),
                        'created_at' => $w->created_at?->toIso8601String(),
                    ];
                }),
            ],
        ]);
    }

    /**
     * Request a referral balance withdrawal (UPI or Bank Transfer).
     */
    public function requestWithdrawal(Request $request)
    {
        $user = $request->user()->fresh();

        $validator = Validator::make($request->all(), [
            'amount' => [
                'required',
                'numeric',
                'min:' . ReferralService::MINIMUM_WITHDRAWAL,
                'max:' . ($user->referral_balance ?? 0),
            ],
            'payout_method' => 'required|string|in:upi,bank',
            'upi_id' => 'required_if:payout_method,upi|nullable|string|max:100',
            'account_holder_name' => 'required_if:payout_method,bank|nullable|string|max:100',
            'account_number' => 'required_if:payout_method,bank|nullable|string|min:6|max:30',
            'ifsc_code' => 'required_if:payout_method,bank|nullable|string|min:4|max:20',
            'bank_name' => 'nullable|string|max:100',
        ], [
            'amount.min' => 'Minimum withdrawal amount is ₹' . ReferralService::MINIMUM_WITHDRAWAL,
            'amount.max' => 'Withdrawal amount cannot exceed your available balance of ₹' . ($user->referral_balance ?? 0),
            'upi_id.required_if' => 'Please enter a valid UPI ID.',
            'account_holder_name.required_if' => 'Account holder name is required for bank transfer.',
            'account_number.required_if' => 'Bank account number is required.',
            'ifsc_code.required_if' => 'IFSC code is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $amount = (float) $request->input('amount');
        $method = $request->input('payout_method');

        if (($user->referral_balance ?? 0) < $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient referral balance.',
            ], 400);
        }

        return DB::transaction(function () use ($user, $amount, $method, $request) {
            // Deduct balance from user
            $user->decrement('referral_balance', $amount);

            // Create withdrawal request record
            $withdrawal = WithdrawalRequest::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'payout_method' => $method,
                'upi_id' => $method === 'upi' ? trim($request->input('upi_id')) : null,
                'account_holder_name' => $method === 'bank' ? trim($request->input('account_holder_name')) : null,
                'account_number' => $method === 'bank' ? trim($request->input('account_number')) : null,
                'ifsc_code' => $method === 'bank' ? strtoupper(trim($request->input('ifsc_code'))) : null,
                'bank_name' => $method === 'bank' ? trim($request->input('bank_name')) : null,
                'status' => 'pending',
            ]);

            // Create transaction ledger entry
            $description = $method === 'upi'
                ? "Withdrawal request to UPI (" . trim($request->input('upi_id')) . ")"
                : "Withdrawal request to Bank (" . trim($request->input('account_holder_name')) . ")";

            ReferralTransaction::create([
                'user_id' => $user->id,
                'amount' => -$amount,
                'type' => 'withdrawal',
                'description' => $description,
                'withdrawal_request_id' => $withdrawal->id,
                'status' => 'pending',
            ]);

            // Notify admins about withdrawal request
            try {
                $admins = \App\Models\User::where('is_admin', true)->get();
                $notificationService = app(\App\Services\NotificationService::class);
                foreach ($admins as $admin) {
                    $notificationService->notify(
                        $admin,
                        'New Withdrawal Request',
                        "{$user->name} requested a withdrawal of ₹{$amount} via " . strtoupper($method) . ".",
                        'info'
                    );
                }
            } catch (\Exception $e) {
                // notification error fallback
            }

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal request of ₹' . number_format($amount, 2) . ' submitted successfully. It will be processed shortly.',
                'data' => [
                    'withdrawal_id' => $withdrawal->id,
                    'remaining_balance' => (float) $user->fresh()->referral_balance,
                ],
            ], 201);
        });
    }
}
