<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;

class AuthController extends Controller
{
    /**
     * Ejercicio 1 – Login por nombre y contraseña.
     * POST /api/login
     */
    public function login(Request $request)
    {
        $alumno = Alumno::where('nombre', $request->nombre)->first();

        if (!$alumno || $request->password !== $alumno->password) {
            return response()->json([
                'error' => 'Credenciales incorrectas.',
            ], 401);
        }

        if ($alumno->tokens()->count() > 0) {
            return response()->json([
                'mensaje' => 'El usuario ya está logeado.',
            ], 200);
        }

        $token = $alumno->createToken('api-token')->plainTextToken;

        return response()->json([
            'mensaje' => 'Login correcto.',
            'token'   => $token,
        ], 200);
    }

    /**
     * Ejercicio 3 – Datos del alumno logeado.
     * GET /api/usuario
     */
    public function usuario(Request $request)
    {
        return response()->json([
            'alumno' => $request->user(),
        ], 200);
    }

    /**
     * Ejercicio 4 – Cerrar sesión (invalidar token).
     * POST /api/logout
     */
    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        $tokenHash = hash('sha256', $token);
        
        \Laravel\Sanctum\PersonalAccessToken::where('token', $tokenHash)->delete();

        return response()->json([
            'mensaje' => 'Sesión cerrada correctamente.',
        ], 200);
    }

    /**
     * Ruta pública de ejemplo – Ejercicio 5.
     * GET /api/publica
     */
    public function publica()
    {
        return response()->json([
            'mensaje' => 'Esta ruta es pública, no necesitas estar logeado.',
        ], 200);
    }
}