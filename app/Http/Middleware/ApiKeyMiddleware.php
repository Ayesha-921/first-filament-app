<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // API key request se lo (header se)
        $apiKey = $request->header('API-KEY');

        // Check karo database me
        $user = User::where('api_key', $apiKey)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Invalid API Key ❌'
            ], 401);
        }

        // Optional: user ko request me attach kar do
        $request->merge(['auth_user' => $user]);

        return $next($request);
    }
}
