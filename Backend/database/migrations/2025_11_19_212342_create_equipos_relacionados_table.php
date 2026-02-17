<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposRelacionadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos_relacionados', function (Blueprint $table) {
            $table->id();

            // Foreigns hacia la misma tabla 'equipos'
            $table->unsignedBigInteger('equipo_id');
            $table->unsignedBigInteger('relacionado_id');

            $table->string('tipo_relacion');
            $table->timestamps();

            // FOREIGN KEYS
            $table->foreign('equipo_id')
                ->references('id')
                ->on('equipos')
                ->cascadeOnDelete();

            $table->foreign('relacionado_id')
                ->references('id')
                ->on('equipos')
                ->cascadeOnDelete();

            // EVITAR DUPLICADOS
            $table->unique(['equipo_id', 'relacionado_id', 'tipo_relacion'], 'relacion_unica');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipos_relacionados');
    }
}
