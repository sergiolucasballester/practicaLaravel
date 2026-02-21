<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;

Route::prefix('alumnos')->group(function () {
    Route::get('/', [AlumnoController::class, 'index'])->name('alumnos.index');
    Route::post('/', [AlumnoController::class, 'store'])->name('alumnos.store');

    Route::middleware('validate.id')->group(function () {
        Route::get('/{id}', [AlumnoController::class, 'show'])->name('alumnos.show');
        Route::put('/{id}', [AlumnoController::class, 'update'])->name('alumnos.update');
        Route::patch('/{id}', [AlumnoController::class, 'update'])->name('alumnos.patch');
        Route::delete('/{id}', [AlumnoController::class, 'destroy'])->name('alumnos.destroy');
    });
});
