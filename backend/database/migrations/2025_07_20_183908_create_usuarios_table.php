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
        Schema::create('usuarios', function (Blueprint $table) {
        $table->id('idUsuario');
        $table->string('nombre');
        $table->string('correo')->unique();
        $table->string('claveCifrada'); // Usaremos este nombre en lugar de 'clave'
        $table->enum('estado', ['activo', 'inactivo'])->default('activo');

        // Un usuario puede pertenecer a un cliente (hotel), pero un admin no. Por eso es nullable.
        $table->foreignId('idCliente')->nullable()->constrained('clientes', 'idCliente')->onDelete('set null');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
