<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipo;

class EquiposTableSeeder extends Seeder
{
    public function run()
    {
        // Ejemplos: 2 unidades por cada tipoEquipo (id 1 a 4)
        
        // TipoEquipo 1
        Equipo::create([
            'tipo_equipo_id' => 1,
            'codigo' => 'MIC-001',
            'estado' => 'DISPONIBLE'
        ]);

        Equipo::create([
            'tipo_equipo_id' => 1,
            'codigo' => 'MIC-002',
            'estado' => 'DISPONIBLE'
        ]);

        // TipoEquipo 2
        Equipo::create([
            'tipo_equipo_id' => 2,
            'codigo' => 'GRAB-001',
            'estado' => 'DISPONIBLE'
        ]);

        Equipo::create([
            'tipo_equipo_id' => 2,
            'codigo' => 'GRAB-002',
            'estado' => 'DISPONIBLE'
        ]);

        // TipoEquipo 3
        Equipo::create([
            'tipo_equipo_id' => 3,
            'codigo' => 'CAM-001',
            'estado' => 'DISPONIBLE'
        ]);

        Equipo::create([
            'tipo_equipo_id' => 3,
            'codigo' => 'CAM-002',
            'estado' => 'DISPONIBLE'
        ]);

        // TipoEquipo 4
        Equipo::create([
            'tipo_equipo_id' => 4,
            'codigo' => 'LED-001',
            'estado' => 'DISPONIBLE'
        ]);

        Equipo::create([
            'tipo_equipo_id' => 4,
            'codigo' => 'LED-002',
            'estado' => 'mantencion'
        ]);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-1',  'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-2',  'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-3',  'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-4',  'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-5',  'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-6',  'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-7',  'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-8',  'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-9',  'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-10', 'estado' => 'DISPONIBLE']);

        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-11', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-12', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-13', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-14', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-15', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-16', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-17', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-18', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-19', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-20', 'estado' => 'DISPONIBLE']);

        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-21', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-22', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-23', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-24', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-25', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-26', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-27', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-28', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-29', 'estado' => 'DISPONIBLE']);
        Equipo::create(['tipo_equipo_id' => 7, 'codigo' => '53071070-30', 'estado' => 'DISPONIBLE']);
        // TipoEquipo 7 – Notebook HP ZBook (10 unidades)
        for ($i = 1; $i <= 10; $i++) {
            Equipo::create([
                'tipo_equipo_id' => 7,
                'codigo' => 'ZBOOK-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'estado' => 'DISPONIBLE'
            ]);
        }

        // TipoEquipo 8 – Luz LED Neewer 660 (5 unidades)
        for ($i = 1; $i <= 5; $i++) {
            Equipo::create([
                'tipo_equipo_id' => 8,
                'codigo' => 'NEEWER-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'estado' => $i === 3 ? 'mantenimiento' : 'DISPONIBLE'
            ]);
        }

    }
}