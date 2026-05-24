<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'error' => 'No autenticado. Token no proporcionado.'
            ], 401);
        }

        $tokenHash = hash('sha256', $token);

        $personalToken = \Laravel\Sanctum\PersonalAccessToken::where('token', $tokenHash)->first();

        if (!$personalToken) {
            return response()->json([
                'error' => 'No autenticado. Token inválido.'
            ], 401);
        }

        $request->setUserResolver(function () use ($personalToken) {
            return $personalToken->tokenable;
        });

        return $next($request);
    }
}