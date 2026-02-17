<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PrestamoSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        /*
        |--------------------------------------------------------------------------
        | PRÉSTAMO 1 - DENTRO
        |--------------------------------------------------------------------------
        */
        $p1 = DB::table('prestamos')->insertGetId([
            'idUser'       => 1,
            'fecha_inicio' => null,
            'fecha_fin'    => null,
            'estado'       => 'pendiente',
            'tipo'         => 'DENTRO',
            'otra_motivo'  => 'Uso en laboratorio',
            'observacion'  => null,
            'created_at'   => $now,
            'updated_at'   => $now,
        ]);

        DB::table('prestamo_equipo')->insert([
            [ 'idPrestamo' => $p1, 'idEquipo' => 1, 'created_at' => $now, 'updated_at' => $now ],
            [ 'idPrestamo' => $p1, 'idEquipo' => 3, 'created_at' => $now, 'updated_at' => $now ],
        ]);

        DB::table('bloque_prestamos')->insert([
            [ 'idPrestamo' => $p1, 'idBloque' => 1, 'idAsignatura' => 1, 'created_at' => $now, 'updated_at' => $now ],
            [ 'idPrestamo' => $p1, 'idBloque' => 2, 'idAsignatura' => 1, 'created_at' => $now, 'updated_at' => $now ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | PRÉSTAMO 2 - FUERA
        |--------------------------------------------------------------------------
        */
        $p2 = DB::table('prestamos')->insertGetId([
            'idUser'       => 2,
            'fecha_inicio' => '2025-11-20',
            'fecha_fin'    => '2025-11-22',
            'estado'       => 'pendiente',
            'tipo'         => 'FUERA',
            'otra_motivo'  => 'Grabación externa',
            'observacion'  => null,
            'created_at'   => $now,
            'updated_at'   => $now,
        ]);

        DB::table('prestamo_equipo')->insert([
            [ 'idPrestamo' => $p2, 'idEquipo' => 2, 'created_at' => $now, 'updated_at' => $now ],
            [ 'idPrestamo' => $p2, 'idEquipo' => 4, 'created_at' => $now, 'updated_at' => $now ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | PRÉSTAMO 3 - DENTRO
        |--------------------------------------------------------------------------
        */
        $p3 = DB::table('prestamos')->insertGetId([
            'idUser'       => 1,
            'fecha_inicio' => null,
            'fecha_fin'    => null,
            'estado'       => 'aprobado',
            'tipo'         => 'DENTRO',
            'otra_motivo'  => 'Práctica guiada',
            'observacion'  => null,
            'created_at'   => $now,
            'updated_at'   => $now,
        ]);

        DB::table('prestamo_equipo')->insert([
            [ 'idPrestamo' => $p3, 'idEquipo' => 5, 'created_at' => $now, 'updated_at' => $now ],
        ]);

        DB::table('bloque_prestamos')->insert([
            [ 'idPrestamo' => $p3, 'idBloque' => 3, 'idAsignatura' => 1, 'created_at' => $now, 'updated_at' => $now ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | PRÉSTAMO 4 - FUERA
        |--------------------------------------------------------------------------
        */
        $p4 = DB::table('prestamos')->insertGetId([
            'idUser'       => 3,
            'fecha_inicio' => '2025-12-01',
            'fecha_fin'    => '2025-12-08',
            'estado'       => 'pendiente',
            'tipo'         => 'FUERA',
            'otra_motivo'  => 'Proyecto personal',
            'observacion'  => 'Debe devolver antes del lunes',
            'created_at'   => $now,
            'updated_at'   => $now,
        ]);

        DB::table('prestamo_equipo')->insert([
            [ 'idPrestamo' => $p4, 'idEquipo' => 1, 'created_at' => $now, 'updated_at' => $now ],
            [ 'idPrestamo' => $p4, 'idEquipo' => 4, 'created_at' => $now, 'updated_at' => $now ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | PRÉSTAMO 5 - DENTRO
        |--------------------------------------------------------------------------
        */
        $p5 = DB::table('prestamos')->insertGetId([
            'idUser'       => 2,
            'fecha_inicio' => null,
            'fecha_fin'    => null,
            'estado'       => 'pendiente',
            'tipo'         => 'DENTRO',
            'otra_motivo'  => 'Clases prácticas',
            'observacion'  => null,
            'created_at'   => $now,
            'updated_at'   => $now,
        ]);

        DB::table('prestamo_equipo')->insert([
            [ 'idPrestamo' => $p5, 'idEquipo' => 2, 'created_at' => $now, 'updated_at' => $now ],
            [ 'idPrestamo' => $p5, 'idEquipo' => 5, 'created_at' => $now, 'updated_at' => $now ],
        ]);

        DB::table('bloque_prestamos')->insert([
            [ 'idPrestamo' => $p5, 'idBloque' => 1, 'idAsignatura' => 1, 'created_at' => $now, 'updated_at' => $now ],
            [ 'idPrestamo' => $p5, 'idBloque' => 2, 'idAsignatura' => 2, 'created_at' => $now, 'updated_at' => $now ],
        ]);
    }
}
