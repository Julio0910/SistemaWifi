<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antena extends Model
{
    use HasFactory;

    protected $table = 'antenas';
    protected $primaryKey = 'idAntena';

    protected $fillable = [
        'nombre',
        'modelo',
        'ip',
        'estado',
        'idGrupoAntena',
    ];
}