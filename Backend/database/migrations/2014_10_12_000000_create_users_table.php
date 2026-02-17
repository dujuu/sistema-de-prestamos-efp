<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('idUser');
            $table->unsignedBigInteger('idPersona');
            $table->string('estadoSancion')->nullable();
            $table->string('Contrasena');
            $table->string('Email')->unique();
            $table->rememberToken();
            $table->timestamps();
             $table->foreign('idPersona')->references('idPersona')->on('persona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
