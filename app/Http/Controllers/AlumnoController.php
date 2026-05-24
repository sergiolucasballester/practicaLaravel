<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * GET /alumnos
     * Muestra todos los alumnos.
     */
    public function index()
    {
        $alumnos = Alumno::all();

        return response()->json([
            'message' => 'Alumnos obtenidos correctamente',
            'data'    => $alumnos,
        ], 200);
    }

    /**
     * GET /alumnos/{id}
     * Muestra un alumno concreto.
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
            'data'    => $alumno,
        ], 200);
    }

    /**
     * GET /alumnos/{id}/expediente
     * Obtiene el expediente del alumno (relación 1:1).
     */
    public function expediente($id)
    {
        $alumno = Alumno::find($id);

        if (!$alumno) {
            return response()->json([
                'error' => 'Alumno no encontrado',
            ], 404);
        }

        $expediente = $alumno->expediente;

        if (!$expediente) {
            return response()->json([
                'error' => 'Este alumno no tiene expediente',
            ], 404);
        }

        return response()->json([
            'message' => 'Expediente obtenido correctamente',
            'data'    => $expediente,
        ], 200);
    }

    /**
     * GET /alumnos/{id}/notas
     * Obtiene todas las notas del alumno (relación 1:N).
     */
    public function notas($id)
    {
        $alumno = Alumno::find($id);

        if (!$alumno) {
            return response()->json([
                'error' => 'Alumno no encontrado',
            ], 404);
        }

        $notas = $alumno->notas;

        return response()->json([
            'message' => 'Notas obtenidas correctamente',
            'data'    => $notas,
        ], 200);
    }

    /**
     * POST /alumnos
     * Crea un nuevo alumno.
     */
    public function store(Request $request)
    {
        $alumno = new Alumno();
        $alumno->nombre = $request->nombre;
        $alumno->email  = $request->email;
        $alumno->edad   = $request->edad;
        $alumno->save();

        return response()->json([
            'message' => 'Alumno creado correctamente',
            'data'    => $alumno,
        ], 201);
    }

    /**
     * PUT /alumnos/{id}
     * Actualiza un alumno.
     */
    public function update(Request $request, $id)
    {
        $alumno = Alumno::find($id);

        if (!$alumno) {
            return response()->json([
                'error' => 'Alumno no encontrado',
            ], 404);
        }

        $alumno->nombre = $request->nombre;
        $alumno->email  = $request->email;
        $alumno->edad   = $request->edad;
        $alumno->save();

        return response()->json([
            'message' => 'Alumno actualizado correctamente',
            'data'    => $alumno,
        ], 200);
    }

    /**
     * DELETE /alumnos/{id}
     * Elimina un alumno.
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