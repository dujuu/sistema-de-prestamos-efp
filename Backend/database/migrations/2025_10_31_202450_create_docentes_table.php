<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('docentes', function (Blueprint $table) {
            $table->id('idDocente');
            $table->string('codigo')->unique();
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('idPersona')->nullable();
            $table->foreign('idPersona')->references('idPersona')->on('persona')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('docentes');
    }
};
