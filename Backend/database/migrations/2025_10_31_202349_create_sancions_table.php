<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sancions', function (Blueprint $table) {
            $table->id('idSancion');
            $table->string('nivel')->nullable();
            $table->enum('estado', ['ACTIVA', 'EXPIRADA'])->default('ACTIVA');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('sancions');
    }
};
