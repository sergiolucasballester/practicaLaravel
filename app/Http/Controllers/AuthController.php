<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Alumno;

class AuthController extends Controller
{
    /**
     * Ejercicio 2 – Registro de usuario.
     * POST /api/register
     */
    public function register(Request $request)
    {
        $alumno = new Alumno();
        $alumno->nombre   = $request->nombre;
        $alumno->email    = $request->email;
        $alumno->password = Hash::make($request->password);
        $alumno->save();

        return response()->json([
            'mensaje' => 'Alumno registrado correctamente.',
            'data'    => $alumno,
        ], 201);
    }

    /**
     * Ejercicio 3 – Login por email O nombre y contraseña.
     * POST /api/login
     */
    public function login(Request $request)
    {
        // Buscar por email o por nombre
        $alumno = Alumno::where('email', $request->input('email'))
                        ->orWhere('nombre', $request->input('nombre'))
                        ->first();

        if (!$alumno || !Hash::check($request->password, $alumno->password)) {
            return response()->json([
                'error' => 'Credenciales incorrectas.',
            ], 401);
        }

        $token = $alumno->createToken('api-token')->accessToken;

        return response()->json([
            'mensaje' => 'Login correcto.',
            'token'   => $token,
        ], 200);
    }

    /**
     * Ejercicio 4 – Datos del alumno logeado.
     * GET /api/usuario
     */
    public function usuario(Request $request)
    {
        return response()->json([
            'alumno' => $request->user(),
        ], 200);
    }

    /**
     * Ejercicio 5 – Cerrar sesión borrando TODOS los tokens.
     * POST /api/logout
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'mensaje' => 'Sesión cerrada correctamente. Todos los tokens eliminados.',
        ], 200);
    }
}