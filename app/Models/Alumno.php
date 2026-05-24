<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Expediente;
use App\Models\Nota;  

class Alumno extends Model
{
    protected $table = 'alumno';

    protected $fillable = [
        'nombre',
        'email',
        'edad',
    ];

    // Relación 1:1 — Un alumno tiene un expediente
    public function expediente()
    {
        return $this->hasOne(Expediente::class);
    }

    // Relación 1:N — Un alumno tiene muchas notas
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }
}