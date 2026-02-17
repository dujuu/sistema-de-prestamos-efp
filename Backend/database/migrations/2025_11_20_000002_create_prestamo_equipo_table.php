<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prestamo_equipo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPrestamo');
            $table->unsignedBigInteger('idEquipo');
            $table->timestamps();

            $table->foreign('idPrestamo')
                ->references('idPrestamo')
                ->on('prestamos')
                ->onDelete('cascade');

            $table->foreign('idEquipo')
                ->references('id')
                ->on('equipos')
                ->onDelete('restrict');

            // Evitar repetir el mismo equipo en el mismo préstamo
            $table->unique(['idPrestamo', 'idEquipo'], 'prestamo_equipo_unico');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamo_equipo');
    }
};
