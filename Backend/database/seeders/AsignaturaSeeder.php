<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsignaturaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('asignaturas')->insert([
            ['nombre' => 'proyecto I'],
            ['nombre' => 'Programación Web'],
            ['nombre' => 'proyecto II'],
            ['nombre' => 'E.F.P. Agilidad'],
            ['nombre' => 'Inteligencia Artificial'],
            ['nombre' => 'Desarrollo de Aplicaciones Móviles'],
            ['nombre' => 'Diseño de Interfaces'],
            ['nombre' => 'Administración de Sistemas'],
            ['nombre' => 'Redes y Seguridad'],
            ['nombre' => 'Bases de Datos'],
        ]);
    }
}
