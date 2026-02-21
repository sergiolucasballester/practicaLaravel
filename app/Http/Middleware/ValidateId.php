<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateId
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');

        // Verificar que el ID es numérico
        if (!is_numeric($id)) {
            return response()->json([
                'error' => 'El ID debe ser numérico',
            ], 400);
        }

        // Verificar que el ID es entero
        if (!is_int((int)$id)) {
            return response()->json([
                'error' => 'El ID debe ser un número entero',
            ], 400);
        }

        // Verificar que el ID es positivo
        if ((int)$id <= 0) {
            return response()->json([
                'error' => 'El ID debe ser positivo',
            ], 400);
        }

        return $next($request);
    }
}
