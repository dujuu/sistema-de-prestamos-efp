<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EquipoRelacionado;

class EquiposRelacionadosSeeder extends Seeder
{
    public function run()
    {
        /**
         * Relacionar cámaras con luces y lentes
         * IDs según tu EquiposTableSeeder
         */

        // Cámara CAM-001 recomienda CAM-002
        EquipoRelacionado::create([
            'equipo_id' => 5,
            'relacionado_id' => 6,
            'tipo_relacion' => 'alternativa'
        ]);

        // Cámara CAM-001 → Luz LED-001
        EquipoRelacionado::create([
            'equipo_id' => 5,
            'relacionado_id' => 7,
            'tipo_relacion' => 'accesorio'
        ]);

        // Cámara CAM-001 → Grabadora H5
        EquipoRelacionado::create([
            'equipo_id' => 5,
            'relacionado_id' => 3,
            'tipo_relacion' => 'complemento'
        ]);

        // Cámara CAM-002 → Luz LED-002
        EquipoRelacionado::create([
            'equipo_id' => 6,
            'relacionado_id' => 8,
            'tipo_relacion' => 'accesorio'
        ]);

        // Luz LED-001 → Cámara CAM-001
        EquipoRelacionado::create([
            'equipo_id' => 7,
            'relacionado_id' => 5,
            'tipo_relacion' => 'uso-recomendado'
        ]);

        // Micrófono MIC-001 → Grabadora GRAB-002
        EquipoRelacionado::create([
            'equipo_id' => 1,
            'relacionado_id' => 4,
            'tipo_relacion' => 'accesorio'
        ]);
    }
}
