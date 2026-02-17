<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoEquipo;

class TipoEquiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Audiovisual (idCategoria = 1)
        TipoEquipo::create([
            'categoria_id' => 1,
            'nombre' => 'Micrófono Rode NT1-A',
            'imagen' => 'equipos/microfono_rode.jpg',
            'descripcion' => 'Micrófono condensador ideal para grabación de voz.'
        ]);

        TipoEquipo::create([
            'categoria_id' => 1,
            'nombre' => 'Grabadora Zoom H5',
            'imagen' => 'equipos/zoom_h5.jpg',
            'descripcion' => 'Grabadora portátil con cápsulas intercambiables.'
        ]);

        // Fotografía (idCategoria = 2)
        TipoEquipo::create([
            'categoria_id' => 2,
            'nombre' => 'Cámara Canon EOS 90D',
            'imagen' => 'equipos/canon_90d.jpg',
            'descripcion' => 'Cámara DSLR de alta resolución ideal para fotos y video.'
        ]);

        TipoEquipo::create([
            'categoria_id' => 2,
            'nombre' => 'Lente 50mm f/1.8',
            'imagen' => 'equipos/lente_50mm.jpg',
            'descripcion' => 'Lente luminoso fijo, perfecto para retratos.'
        ]);

        // Equipo Computacional (idCategoria = 3)
        TipoEquipo::create([
            'categoria_id' => 3,
            'nombre' => 'Notebook Lenovo i5',
            'imagen' => 'equipos/lenovo_i5.jpg',
            'descripcion' => 'Notebook para uso académico y edición ligera.'
        ]);

        TipoEquipo::create([
            'categoria_id' => 3,
            'nombre' => 'Tablet Wacom Intuos',
            'imagen' => 'equipos/wacom_intuos.jpg',
            'descripcion' => 'Tableta digitalizadora para diseño gráfico.'
        ]);

        TipoEquipo::create([
            'categoria_id' => 3,
            'nombre' => 'Notebook HP ZBook',
            'imagen' => null,
            'descripcion' => 'Notebook HP ZBook del inventario institucional.'
        ]);

        // Iluminación (idCategoria = 4)
        TipoEquipo::create([
            'categoria_id' => 4,
            'nombre' => 'Luz LED Neewer 660',
            'imagen' => 'equipos/neewer_660.jpg',
            'descripcion' => 'Panel LED bicolor con gran capacidad de iluminación.'
        ]);

        TipoEquipo::create([
            'categoria_id' => 4,
            'nombre' => 'Softbox 80x80',
            'imagen' => 'equipos/softbox_80.jpg',
            'descripcion' => 'Difusor para iluminación suave en fotografía y video.'
        ]);
    }
}
