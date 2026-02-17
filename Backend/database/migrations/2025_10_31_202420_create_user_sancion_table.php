<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_sancion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idSancion');
            $table->foreign('idUser')->references('idUser')->on('users')->onDelete('cascade');
            $table->foreign('idSancion')->references('idSancion')->on('sancions')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_sancion');
    }
};
