<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the authenticated user's role matches the required role for this route
        if (auth()->check() && auth()->user()->role === $role) {
            return $next($request);
        }

        // If the user's role does not match, return an unauthorized response
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
