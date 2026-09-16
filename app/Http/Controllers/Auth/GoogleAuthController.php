<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function handleFirebaseCallback(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'nullable|string',
            'uid' => 'required|string',
            'photo' => 'nullable|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->name ?? 'Google User',
                'email' => $request->email,
                'password' => Hash::make(Str::random(24)),
                'profile_photo' => $request->photo,
                'is_verified' => true,
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, true);

        $redirect = $user->is_admin ? '/admin' : '/dashboard';

        return response()->json([
            'success' => true,
            'is_admin' => (bool) $user->is_admin,
            'redirect' => $redirect,
        ]);
    }
}
