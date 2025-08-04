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
         Schema::create('eventos', function (Blueprint $table) {
        $table->id('idEvento');
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->dateTime('fechaInicio');
        $table->dateTime('fechaFin');
        $table->integer('asistentesEstimados');

        // Aquí creamos la relación con la tabla 'clientes'
        $table->foreignId('idCliente')->constrained('clientes', 'idCliente')->onDelete('cascade');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
