<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <-- 1. ASEGÚRATE DE IMPORTAR ESTO

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens; // <-- 2. ASEGÚRATE DE USAR ESTO

    protected $table = 'usuarios';
    protected $primaryKey = 'idUsuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'correo',
        'claveCifrada',
        'estado',
        'idCliente',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'claveCifrada',
    ];
}