<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alumno')->insert([
            [
                'nombre' => 'Juan García',
                'telefono' => '612345678',
                'edad' => 20,
                'password' => Hash::make('password123'),
                'email' => 'juan@example.com',
                'sexo' => 'M',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María López',
                'telefono' => '623456789',
                'edad' => 21,
                'password' => Hash::make('password123'),
                'email' => 'maria@example.com',
                'sexo' => 'F',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Carlos Rodríguez',
                'telefono' => '634567890',
                'edad' => 19,
                'password' => Hash::make('password123'),
                'email' => 'carlos@example.com',
                'sexo' => 'M',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ana Martínez',
                'telefono' => null,
                'edad' => 22,
                'password' => Hash::make('password123'),
                'email' => 'ana@example.com',
                'sexo' => 'F',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedro Sánchez',
                'telefono' => '645678901',
                'edad' => null,
                'password' => Hash::make('password123'),
                'email' => 'pedro@example.com',
                'sexo' => 'M',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
