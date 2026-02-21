<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AlumnoController extends Controller
{
    /**
     * Display a listing of all alumnos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $alumnos = Alumno::all();

        return response()->json([
            'message' => 'Alumnos obtenidos correctamente',
            'data' => $alumnos,
        ], 200);
    }

    /**
     * Display the specified alumno by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $alumno = Alumno::find($id);

        if (!$alumno) {
            return response()->json([
                'error' => 'Alumno no encontrado',
            ], 404);
        }

        return response()->json([
            'message' => 'Alumno obtenido correctamente',
            'data' => $alumno,
        ], 200);
    }

    /**
     * Store a newly created alumno in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:32',
                'telefono' => 'nullable|string|max:16',
                'edad' => 'nullable|integer|min:1|max:150',
                'password' => 'required|string|min:6|max:64',
                'email' => 'required|email|max:64|unique:alumno,email',
                'sexo' => 'nullable|string|max:1',
            ]);

            $validated['password'] = Hash::make($validated['password']);

            $alumno = Alumno::create($validated);

            return response()->json([
                'message' => 'Alumno creado correctamente',
                'data' => $alumno,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Error de validación',
                'messages' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Update the specified alumno in database.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $alumno = Alumno::find($id);

        if (!$alumno) {
            return response()->json([
                'error' => 'Alumno no encontrado',
            ], 404);
        }

        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|required|string|max:32',
                'telefono' => 'nullable|string|max:16',
                'edad' => 'nullable|integer|min:1|max:150',
                'password' => 'sometimes|required|string|min:6|max:64',
                'email' => 'sometimes|required|email|max:64|unique:alumno,email,' . $id,
                'sexo' => 'nullable|string|max:1',
            ]);

            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            $alumno->update($validated);

            return response()->json([
                'message' => 'Alumno actualizado correctamente',
                'data' => $alumno,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Error de validación',
                'messages' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Remove the specified alumno from database.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $alumno = Alumno::find($id);

        if (!$alumno) {
            return response()->json([
                'error' => 'Alumno no encontrado',
            ], 404);
        }

        $alumno->delete();

        return response()->json([
            'message' => 'Alumno eliminado correctamente',
        ], 200);
    }
}
