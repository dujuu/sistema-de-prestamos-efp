<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BloquePrestamosSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('bloquePrestamos')->truncate();

        DB::table('bloquePrestamos')->insert([
            ['idBloque' => 1, 'idPrestamo' => 1, 'idAsignatura' => 1],
            ['idBloque' => 2, 'idPrestamo' => 1, 'idAsignatura' => 2],
            ['idBloque' => 3, 'idPrestamo' => 2, 'idAsignatura' => 3],
            ['idBloque' => 1, 'idPrestamo' => 3, 'idAsignatura' => 4],
            ['idBloque' => 2, 'idPrestamo' => 4, 'idAsignatura' => 5],
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
