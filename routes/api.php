<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\AuthController;

// -------------------------------------------------------
// RUTAS PÚBLICAS (sin autenticación)
// -------------------------------------------------------
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// -------------------------------------------------------
// RUTAS PROTEGIDAS (requieren token Passport)
// -------------------------------------------------------
Route::middleware('check.token')->group(function () {

    // Auth
    Route::get('/usuario', [AuthController::class, 'usuario']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // RUTAS ALUMNO (CRUD básico)
    Route::get('/alumnos',       [AlumnoController::class, 'index']);
    Route::get('/alumnos/{id}',  [AlumnoController::class, 'show']);
    Route::post('/alumnos',      [AlumnoController::class, 'store']);
    Route::put('/alumnos/{id}',  [AlumnoController::class, 'update']);
    Route::delete('/alumnos/{id}', [AlumnoController::class, 'destroy']);

    // Relación 1:1
    Route::get('/alumnos/{id}/expediente', [AlumnoController::class, 'expediente']);

    // Relación 1:N
    Route::get('/alumnos/{id}/notas', [AlumnoController::class, 'notas']);

    // RUTAS EXPEDIENTE
    Route::get('/expedientes',       [ExpedienteController::class, 'index']);
    Route::get('/expedientes/{id}',  [ExpedienteController::class, 'show']);
    Route::post('/expedientes',      [ExpedienteController::class, 'store']);
    Route::delete('/expedientes/{id}', [ExpedienteController::class, 'destroy']);
    Route::get('/expedientes/{id}/alumno', [ExpedienteController::class, 'alumno']);

    // RUTAS NOTA
    Route::get('/notas',       [NotaController::class, 'index']);
    Route::get('/notas/{id}',  [NotaController::class, 'show']);
    Route::post('/notas',      [NotaController::class, 'store']);
    Route::delete('/notas/{id}', [NotaController::class, 'destroy']);
    Route::get('/notas/{id}/alumno', [NotaController::class, 'alumno']);
});