<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observaciones', function (Blueprint $table) {
$table->id('idObservacion');
            $table->unsignedBigInteger('idPrestamo'); 
            
            $table->string('descripcion', 255)->nullable();
            $table->string('estado', 50)->default('habilitado');
            
            // 🔹 Clave foránea
            $table->foreign('idPrestamo')
                  ->references('idPrestamo')
                  ->on('prestamos')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observaciones');
    }
}
