<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocenteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('docentes')->insert([
            [
                'codigo' => 'DOC001',
                'descripcion' => 'Docente de Diseño y UX',
                'idPersona' => 1,
            ],
            [
                'codigo' => 'DOC002',
                'descripcion' => 'Docente de Programación y Backend',
                'idPersona' => 2,
            ],
            [
                'codigo' => 'DOC003',
                'descripcion' => 'Docente de Modelado y Animación',
                'idPersona' => 3,
            ],
        ]);
    }
}
