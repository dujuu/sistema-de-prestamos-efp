<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloquePrestamosTable extends Migration
{
    public function up()
    {
        Schema::create('bloque_prestamos', function (Blueprint $table) {
            $table->id('idBloquePrestamo');

            $table->unsignedBigInteger('idPrestamo');
            $table->unsignedBigInteger('idBloque');
            $table->unsignedBigInteger('idAsignatura')->nullable();
            $table->timestamps();

            // Relaciones
            $table->foreign('idPrestamo')
                ->references('idPrestamo')
                ->on('prestamos')
                ->onDelete('cascade');

            $table->foreign('idBloque')
                ->references('idBloque')
                ->on('bloques')
                ->onDelete('cascade');

            $table->foreign('idAsignatura')
                ->references('idAsignatura')
                ->on('asignaturas')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bloque_prestamos');
    }
}
