<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            // Mantienes tu PK original
            $table->id('id');

            // Nueva FK hacia tipos de equipo
            $table->unsignedBigInteger('tipo_equipo_id');

            // Código único (etiqueta física del equipo)
            $table->string('codigo')->unique();

            // Estado de la unidad física
            $table->string('estado')->default('disponible');

            $table->timestamps();

            // Foreign Key
            $table->foreign('tipo_equipo_id')
                  ->references('id')
                  ->on('tipo_equipos')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('equipos');
    }
}
