<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asignatura_docente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idAsignatura');
            $table->unsignedBigInteger('idDocente');
            $table->foreign('idAsignatura')->references('idAsignatura')->on('asignaturas')->onDelete('cascade');
            $table->foreign('idDocente')->references('idDocente')->on('docentes')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('asignatura_docente');
    }
};
