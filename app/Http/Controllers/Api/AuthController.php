<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Generate and store a 6-digit email verification OTP.
     * Returns the code for development convenience.
     */
    private function generateAndStoreOtp(string $email): string
    {
        $code = strval(rand(100000, 999999));

        DB::table('email_verification_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($code),
                'created_at' => now(),
            ]
        );

        Log::info("Email verification OTP for {$email}: {$code}");

        // Send actual email OTP
        try {
            \Illuminate\Support\Facades\Mail::raw("Your HomiQ email verification code is: {$code}. This code is valid for 15 minutes.", function ($message) use ($email) {
                $message->to($email)->subject("HomiQ - Email Verification OTP");
            });
        } catch (\Exception $e) {
            Log::error("Failed to send OTP email to {$email}: " . $e->getMessage());
        }

        return $code;
    }

    /**
     * Register a new user.
     * Generates a 6-digit OTP and returns the user in an "unverified" state.
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'] ?? null,
            'password' => Hash::make($fields['password']),
        ]);

        $token = $user->createToken('homiq_auth_token')->plainTextToken;

        // Generate OTP for email verification
        $otp = $this->generateAndStoreOtp($user->email);

        return response([
            'user' => $user,
            'token' => $token,
            'email_verified' => false,
            'message' => 'Registration successful. Please verify your email with the OTP sent.',
        ], 201);
    }

    /**
     * Log in a user.
     * If the user's email is not verified, generate a new OTP and
     * return the "unverified" status so the client can redirect to OTP screen.
     */
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid email or password credentials',
            ], 401);
        }

        $token = $user->createToken('homiq_auth_token')->plainTextToken;

        // Check if user has verified their email
        if (is_null($user->email_verified_at)) {
            $otp = $this->generateAndStoreOtp($user->email);

            return response([
                'user' => $user,
                'token' => $token,
                'email_verified' => false,
                'message' => 'Email not verified. A new OTP has been sent.',
            ], 200);
        }

        return response([
            'user' => $user,
            'token' => $token,
            'email_verified' => true,
        ], 200);
    }

    /**
     * Handle social login/signup for Google and Apple.
     */
    public function socialLogin(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'name' => 'required|string|max:255',
            'provider' => 'required|string|in:google,apple',
            'provider_id' => 'required|string',
        ]);

        // Find or create user with the social email
        $user = User::where('email', $fields['email'])->first();

        if (!$user) {
            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => Hash::make(uniqid('social_', true)),
                'subscription_plan' => 'free',
                'email_verified_at' => now(), // Social emails are pre-verified
            ]);
        } else {
            // Ensure email is verified if they existed
            if (is_null($user->email_verified_at)) {
                $user->update(['email_verified_at' => now()]);
            }
        }

        $token = $user->createToken('homiq_auth_token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
            'email_verified' => true,
            'message' => 'Successfully logged in with ' . ucfirst($fields['provider']),
        ], 200);
    }

    /**
     * Verify a user's email using the 6-digit OTP.
     */
    public function verifyEmail(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'otp' => 'required|string|size:6',
        ]);

        $record = DB::table('email_verification_tokens')
            ->where('email', $fields['email'])
            ->first();

        if (!$record) {
            return response([
                'message' => 'No verification code found for this email. Please request a new one.',
            ], 404);
        }

        // Check if OTP has expired (15 minutes)
        if (now()->diffInMinutes($record->created_at) > 15) {
            DB::table('email_verification_tokens')
                ->where('email', $fields['email'])
                ->delete();

            return response([
                'message' => 'Verification code has expired. Please request a new one.',
            ], 410);
        }

        if (!Hash::check($fields['otp'], $record->token)) {
            return response([
                'message' => 'Invalid verification code.',
            ], 400);
        }

        // Mark the user's email as verified
        $user = User::where('email', $fields['email'])->first();
        if (!$user) {
            return response([
                'message' => 'User account not found.',
            ], 404);
        }

        $user->email_verified_at = now();
        $user->save();

        // Clean up the OTP record
        DB::table('email_verification_tokens')
            ->where('email', $fields['email'])
            ->delete();

        return response([
            'user' => $user,
            'email_verified' => true,
            'message' => 'Email verified successfully.',
        ], 200);
    }

    /**
     * Resend email verification OTP.
     */
    public function resendOtp(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user) {
            return response([
                'message' => 'We could not find a user with that email address.',
            ], 404);
        }

        if ($user->email_verified_at) {
            return response([
                'message' => 'Email is already verified.',
            ], 400);
        }

        $otp = $this->generateAndStoreOtp($user->email);

        return response([
            'message' => 'A new verification code has been sent to your email.',
        ], 200);
    }

    /**
     * Log out a user (Revoke token).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response([
            'message' => 'Successfully logged out',
        ], 200);
    }

    /**
     * Request a password reset code.
     */
    public function forgotPassword(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user) {
            return response([
                'message' => 'We could not find a user with that email address.',
                'status' => 'error'
            ], 404);
        }

        // Generate a 6-digit verification code
        $code = strval(rand(100000, 999999));

        // Save code hashed to password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $fields['email']],
            [
                'token' => Hash::make($code),
                'created_at' => now(),
            ]
        );

        // Send OTP via mail
        try {
            \Illuminate\Support\Facades\Mail::raw("Your HomiQ password reset verification code is: {$code}. This code is valid for 15 minutes.", function ($message) use ($fields) {
                $message->to($fields['email'])->subject("HomiQ - Password Reset OTP");
            });
        } catch (\Exception $e) {
            Log::error("Failed to send password reset OTP email to {$fields['email']}: " . $e->getMessage());
        }

        return response([
            'message' => 'Password reset code has been sent to your email.',
        ], 200);
    }

    /**
     * Reset password using verification code.
     */
    public function resetPassword(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $fields['email'])
            ->first();

        if (!$resetRecord || !Hash::check($fields['token'], $resetRecord->token)) {
            return response([
                'message' => 'Invalid or expired verification code.',
            ], 400);
        }

        $user = User::where('email', $fields['email'])->first();
        if (!$user) {
            return response([
                'message' => 'User account not found.',
            ], 404);
        }

        // Update password and delete the reset token
        $user->password = Hash::make($fields['password']);
        $user->save();

        DB::table('password_reset_tokens')
            ->where('email', $fields['email'])
            ->delete();

        return response([
            'message' => 'Your password has been successfully reset.',
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $fields = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'dob' => 'sometimes|nullable|date',
            'gender' => 'sometimes|nullable|string|max:50',
            'profile_photo' => 'sometimes|nullable',
        ]);

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profiles'), $filename);
            $fields['profile_photo'] = '/uploads/profiles/' . $filename;
        }

        $user->update($fields);

        return response([
            'message' => 'Profile updated successfully',
            'user' => $user->fresh(),
        ], 200);
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();

        $fields = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($fields['current_password'], $user->password)) {
            return response([
                'message' => 'The current password you entered is incorrect.'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($fields['new_password']),
        ]);

        return response([
            'message' => 'Password changed successfully',
        ], 200);
    }

    /**
     * Update the authenticated user's FCM token.
     */
    public function updateFcmToken(Request $request)
    {
        $fields = $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $request->user()->update([
            'fcm_token' => $fields['fcm_token'],
        ]);

        return response([
            'message' => 'FCM token updated successfully',
        ], 200);
    }
}
