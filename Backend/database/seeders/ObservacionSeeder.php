<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObservacionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('observaciones')->insert([
            ['idPrestamo' => 1, 'descripcion' => 'Equipo devuelto con retraso', 'estado' => 'pendiente'],
            ['idPrestamo' => 2, 'descripcion' => 'Daños menores detectados', 'estado' => 'revisado'],
            ['idPrestamo' => 3, 'descripcion' => 'Usuario no se presentó', 'estado' => 'pendiente'],
            ['idPrestamo' => 4, 'descripcion' => 'Falta de accesorios', 'estado' => 'pendiente'],
            ['idPrestamo' => 5, 'descripcion' => 'Entrega correcta', 'estado' => 'cerrado'],
        ]);
    }
}
