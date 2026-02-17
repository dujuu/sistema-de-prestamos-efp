<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->id('idPersona'); // Renombra 'id' a 'IdPersona'
            $table->string('Nombre');
            $table->string('apellido1');
            $table->string('apellido2')->nullable();
            $table->string('Rut')->unique();
            $table->string('Email')->unique();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
           

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
