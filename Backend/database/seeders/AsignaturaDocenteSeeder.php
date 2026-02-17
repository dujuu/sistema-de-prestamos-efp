<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsignaturaDocenteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('asignatura_docente')->insert([
            ['idAsignatura' => 1, 'idDocente' => 1],
            ['idAsignatura' => 2, 'idDocente' => 2],
            ['idAsignatura' => 3, 'idDocente' => 3],
            ['idAsignatura' => 4, 'idDocente' => 3],
            ['idAsignatura' => 5, 'idDocente' => 2],
        ]);
    }
}
