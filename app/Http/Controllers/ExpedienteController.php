<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expediente;

class ExpedienteController extends Controller
{
    /**
     * GET /expedientes
     * Muestra todos los expedientes.
     */
    public function index()
    {
        $expedientes = Expediente::all();

        return response()->json([
            'message' => 'Expedientes obtenidos correctamente',
            'data'    => $expedientes,
        ], 200);
    }

    /**
     * GET /expedientes/{id}
     * Muestra un expediente concreto.
     */
    public function show($id)
    {
        $expediente = Expediente::find($id);

        if (!$expediente) {
            return response()->json([
                'error' => 'Expediente no encontrado',
            ], 404);
        }

        return response()->json([
            'message' => 'Expediente obtenido correctamente',
            'data'    => $expediente,
        ], 200);
    }

    /**
     * GET /expedientes/{id}/alumno
     * Obtiene el alumno de un expediente (relación inversa 1:1).
     */
    public function alumno($id)
    {
        $expediente = Expediente::find($id);

        if (!$expediente) {
            return response()->json([
                'error' => 'Expediente no encontrado',
            ], 404);
        }

        $alumno = $expediente->alumno;

        return response()->json([
            'message' => 'Alumno del expediente obtenido correctamente',
            'data'    => $alumno,
        ], 200);
    }

    /**
     * POST /expedientes
     * Crea un nuevo expediente.
     */
    public function store(Request $request)
    {
        $expediente = new Expediente();
        $expediente->alumno_id          = $request->alumno_id;
        $expediente->numero_expediente  = $request->numero_expediente;
        $expediente->fecha_inicio       = $request->fecha_inicio;
        $expediente->save();

        return response()->json([
            'message' => 'Expediente creado correctamente',
            'data'    => $expediente,
        ], 201);
    }

    /**
     * DELETE /expedientes/{id}
     * Elimina un expediente.
     */
    public function destroy($id)
    {
        $expediente = Expediente::find($id);

        if (!$expediente) {
            return response()->json([
                'error' => 'Expediente no encontrado',
            ], 404);
        }

        $expediente->delete();

        return response()->json([
            'message' => 'Expediente eliminado correctamente',
        ], 200);
    }
}
