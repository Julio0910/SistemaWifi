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
        Schema::create('grupos_antena', function (Blueprint $table) {
        $table->id('idGrupoAntena');
        $table->string('nombre');
        $table->text('descripcion')->nullable();

        // Relación con el cliente
        $table->foreignId('idCliente')->constrained('clientes', 'idCliente')->onDelete('cascade');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos_antena');
    }
};
