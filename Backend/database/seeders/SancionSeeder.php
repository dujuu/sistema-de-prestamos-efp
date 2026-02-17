<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SancionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sancions')->insert([
            ['nivel' => null, 'estado' => 'ACTIVA', 'fecha_inicio' => '2025-10-01', 'fecha_fin' => '2025-11-01'],
            ['nivel' => null, 'estado' => 'EXPIRADA', 'fecha_inicio' => '2025-09-01', 'fecha_fin' => '2025-10-15'],
            ['nivel' => null, 'estado' => 'ACTIVA', 'fecha_inicio' => '2025-10-20', 'fecha_fin' => '2025-11-20'],
            ['nivel' => null, 'estado' => 'ACTIVA', 'fecha_inicio' => '2025-09-10', 'fecha_fin' => '2025-09-30'],
            ['nivel' => null, 'estado' => 'EXPIRADA', 'fecha_inicio' => '2025-08-01', 'fecha_fin' => '2025-09-01'],
        ]);
    }
}
