<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expediente', function (Blueprint $table) {
            $table->id();
            // Clave foránea hacia alumno (relación 1:1)
            $table->unsignedBigInteger('alumno_id')->unique();
            $table->string('numero_expediente', 50);
            $table->date('fecha_inicio')->nullable();
            $table->timestamps();

            $table->foreign('alumno_id')
                  ->references('id')
                  ->on('alumno')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expediente');
    }
};