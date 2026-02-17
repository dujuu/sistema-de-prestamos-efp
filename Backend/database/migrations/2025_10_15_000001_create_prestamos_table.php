<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id('idPrestamo');

            // Usuario que realiza la solicitud
            $table->unsignedBigInteger('idUser');

            // Fechas (solo requeridas para tipo FUERA)
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            // Estado del préstamo
            $table->string('estado')->default('pendiente');

            // Motivo informado por el usuario
            $table->string('otra_motivo')->nullable();

            // Tipo de préstamo: DENTRO o FUERA
            $table->string('tipo')->default('externo');

            // Observaciones (admin o usuario)
            $table->string('observacion')->nullable();

            $table->timestamps();

            // Foreign Key
            $table->foreign('idUser')
                ->references('idUser')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
