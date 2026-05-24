<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    protected $table = 'expediente';

    protected $fillable = [
        'alumno_id',
        'numero_expediente',
        'fecha_inicio',
    ];

    // Relación inversa 1:1 — El expediente pertenece a un alumno
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
