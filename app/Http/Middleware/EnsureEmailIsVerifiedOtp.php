<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerifiedOtp
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && is_null(Auth::user()->email_verified_at)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your email address is not verified.'], 403);
            }
            return redirect('/verify-email');
        }

        return $next($request);
    }
}
