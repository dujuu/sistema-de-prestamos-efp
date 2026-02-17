<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asignaturas', function (Blueprint $table) {
            $table->id('idAsignatura');
            $table->string('nombre');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('asignaturas');
    }
};
