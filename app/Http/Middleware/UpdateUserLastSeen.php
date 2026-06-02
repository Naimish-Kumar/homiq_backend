<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = null;
        if (Auth::check()) {
            $user = Auth::user();
        } elseif ($request->bearerToken()) {
            $user = Auth::guard('sanctum')->user();
        }

        if ($user) {
            $user->last_seen_at = now();
            $user->timestamps = false;
            $user->save();
        }

        return $next($request);
    }
}
