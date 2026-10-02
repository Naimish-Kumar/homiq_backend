<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthorized. Administrator access required.'
            ], 403);
        }

        return redirect('/login')->withErrors([
            'email' => 'Please log in with an administrator account to access this area.',
        ]);
    }
}
