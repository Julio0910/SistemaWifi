<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoAntena extends Model
{
    use HasFactory;

    protected $table = 'grupos_antena';
    protected $primaryKey = 'idGrupoAntena';

    protected $fillable = [
        'nombre',
        'descripcion',
        'idCliente',
    ];

    public function antenas()
    {
        return $this->hasMany(Antena::class, 'idGrupoAntena');
    }
}