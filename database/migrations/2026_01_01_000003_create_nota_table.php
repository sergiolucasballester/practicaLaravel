<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nota', function (Blueprint $table) {
            $table->id();
            // Clave foránea hacia alumno (relación 1:N)
            $table->unsignedBigInteger('alumno_id');
            $table->string('asignatura', 100);
            $table->decimal('calificacion', 4, 2);
            $table->timestamps();

            $table->foreign('alumno_id')
                  ->references('id')
                  ->on('alumno')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nota');
    }
};