<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Alumno;  

class Nota extends Model
{
    protected $table = 'nota';

    protected $fillable = [
        'alumno_id',
        'asignatura',
        'calificacion',
    ];

    // Relación inversa 1:N — La nota pertenece a un alumno
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}