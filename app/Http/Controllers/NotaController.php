<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nota;

class NotaController extends Controller
{
    /**
     * GET /notas
     * Muestra todas las notas.
     */
    public function index()
    {
        $notas = Nota::all();

        return response()->json([
            'message' => 'Notas obtenidas correctamente',
            'data'    => $notas,
        ], 200);
    }

    /**
     * GET /notas/{id}
     * Muestra una nota concreta.
     */
    public function show($id)
    {
        $nota = Nota::find($id);

        if (!$nota) {
            return response()->json([
                'error' => 'Nota no encontrada',
            ], 404);
        }

        return response()->json([
            'message' => 'Nota obtenida correctamente',
            'data'    => $nota,
        ], 200);
    }

    /**
     * GET /notas/{id}/alumno
     * Obtiene el alumno de una nota (relación inversa 1:N).
     */
    public function alumno($id)
    {
        $nota = Nota::find($id);

        if (!$nota) {
            return response()->json([
                'error' => 'Nota no encontrada',
            ], 404);
        }

        $alumno = $nota->alumno;

        return response()->json([
            'message' => 'Alumno de la nota obtenido correctamente',
            'data'    => $alumno,
        ], 200);
    }

    /**
     * POST /notas
     * Crea una nueva nota.
     */
    public function store(Request $request)
    {
        $nota = new Nota();
        $nota->alumno_id    = $request->alumno_id;
        $nota->asignatura   = $request->asignatura;
        $nota->calificacion = $request->calificacion;
        $nota->save();

        return response()->json([
            'message' => 'Nota creada correctamente',
            'data'    => $nota,
        ], 201);
    }

    /**
     * DELETE /notas/{id}
     * Elimina una nota.
     */
    public function destroy($id)
    {
        $nota = Nota::find($id);

        if (!$nota) {
            return response()->json([
                'error' => 'Nota no encontrada',
            ], 404);
        }

        $nota->delete();

        return response()->json([
            'message' => 'Nota eliminada correctamente',
        ], 200);
    }
}
