<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('antenas', function (Blueprint $table) {
        $table->id('idAntena');
        $table->string('nombre');
        $table->string('modelo')->nullable();
        $table->ipAddress('ip')->unique(); // Columna especial para direcciones IP
        $table->enum('estado', ['online', 'offline', 'error'])->default('offline');

        // Relación con el grupo al que pertenece la antena
        $table->foreignId('idGrupoAntena')->constrained('grupos_antena', 'idGrupoAntena')->onDelete('cascade');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antenas');
    }
};
