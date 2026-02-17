<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloqueSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bloques')->insert([
            ['nombre' => 'Bloque 1', 'hora_inicio' => '08:00:00', 'hora_fin' => '09:30:00'],
            ['nombre' => 'Bloque 2', 'hora_inicio' => '09:40:00', 'hora_fin' => '11:10:00'],
            ['nombre' => 'Bloque 3', 'hora_inicio' => '11:20:00', 'hora_fin' => '12:50:00'],
            ['nombre' => 'Bloque 4', 'hora_inicio' => '12:50:00', 'hora_fin' => '14:40:00'],
            ['nombre' => 'Bloque 5', 'hora_inicio' => '14:45:00', 'hora_fin' => '16:10:00'],
            ['nombre' => 'Bloque 6', 'hora_inicio' => '16:20:00', 'hora_fin' => '17:50:00'],
            ['nombre' => 'Bloque 7', 'hora_inicio' => '17:55:00', 'hora_fin' => '19:30:00'],
            ['nombre' => 'Bloque 8', 'hora_inicio' => '19:40:00', 'hora_fin' => '21:10:00'],
        ]);
    }
}
