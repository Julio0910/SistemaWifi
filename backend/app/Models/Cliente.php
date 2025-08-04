<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes'; // Le indicamos que este modelo usa la tabla 'clientes'
    protected $primaryKey = 'idCliente'; // Le decimos cuál es su llave primaria

    // Definimos los campos que se pueden llenar masivamente para seguridad
    protected $fillable = [
        'nombreEmpresa',
        'razonSocial',
        'correo',
        'telefono',
        'rtn',
        'direccion',
        'estado',
    ];

    // Definimos la relación: Un cliente puede tener muchos eventos
    public function eventos()
    {
        return $this->hasMany(Evento::class, 'idCliente');
    }
}