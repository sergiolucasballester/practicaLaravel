<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckToken
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user('api');
        
        if (!$user) {
            return response()->json([
                'error' => 'No autenticado. Token inválido o no proporcionado.'
            ], 401);
        }

        // Establecer el usuario para que $request->user() funcione en los controladores
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}