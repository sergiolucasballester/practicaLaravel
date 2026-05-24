<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\NotaController;

// -------------------------------------------------------
// RUTAS ALUMNO (CRUD básico)
// -------------------------------------------------------
Route::get('/alumnos', [AlumnoController::class, 'index']);
Route::get('/alumnos/{id}', [AlumnoController::class, 'show']);
Route::post('/alumnos', [AlumnoController::class, 'store']);
Route::put('/alumnos/{id}', [AlumnoController::class, 'update']);
Route::delete('/alumnos/{id}', [AlumnoController::class, 'destroy']);

// -------------------------------------------------------
// RUTAS DE RELACIÓN — desde Alumno
// -------------------------------------------------------

// Relación 1:1 — Obtener el expediente de un alumno
Route::get('/alumnos/{id}/expediente', [AlumnoController::class, 'expediente']);

// Relación 1:N — Obtener todas las notas de un alumno
Route::get('/alumnos/{id}/notas', [AlumnoController::class, 'notas']);

// -------------------------------------------------------
// RUTAS EXPEDIENTE
// -------------------------------------------------------
Route::get('/expedientes', [ExpedienteController::class, 'index']);
Route::get('/expedientes/{id}', [ExpedienteController::class, 'show']);
Route::post('/expedientes', [ExpedienteController::class, 'store']);
Route::delete('/expedientes/{id}', [ExpedienteController::class, 'destroy']);

// Relación inversa 1:1 — Obtener el alumno de un expediente
Route::get('/expedientes/{id}/alumno', [ExpedienteController::class, 'alumno']);

// -------------------------------------------------------
// RUTAS NOTA
// -------------------------------------------------------
Route::get('/notas', [NotaController::class, 'index']);
Route::get('/notas/{id}', [NotaController::class, 'show']);
Route::post('/notas', [NotaController::class, 'store']);
Route::delete('/notas/{id}', [NotaController::class, 'destroy']);

// Relación inversa 1:N — Obtener el alumno de una nota
Route::get('/notas/{id}/alumno', [NotaController::class, 'alumno']);