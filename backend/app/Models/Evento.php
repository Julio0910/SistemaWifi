<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';
    protected $primaryKey = 'idEvento';

    protected $fillable = [
        'nombre',
        'descripcion',
        'fechaInicio',
        'fechaFin',
        'asistentesEstimados',
        'idCliente',
    ];

    // Definimos la relación inversa: Un evento pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idCliente');
    }
}