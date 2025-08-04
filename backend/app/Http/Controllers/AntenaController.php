<?php

namespace App\Http\Controllers;

use App\Models\Antena;
use Illuminate\Http\Request;

class AntenaController extends Controller
{
    public function index()
    {
        return Antena::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'ip' => 'required|ip|unique:antenas,ip',
            'idGrupoAntena' => 'required|exists:grupos_antena,idGrupoAntena',
        ]);
        $antena = Antena::create($validated);
        return response()->json($antena, 201);
    }
}