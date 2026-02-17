<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
            'nombre' => 'notebook',
            'descripcion' => 'Computadores portátiles.'
        ]);

        Categoria::create([
            'nombre' => 'raspberry',
            'descripcion' => 'Computadores de placa única.'
        ]);

        Categoria::create([
            'nombre' => 'lego',
            'descripcion' => 'Set de bloques de construcción.'
        ]);

        Categoria::create([
            'nombre' => 'monitor',
            'descripcion' => 'Monitores y pantallas.'
        ]);
    }
}
