<?php

namespace App\Http\Controllers;

use App\Models\GrupoAntena;
use Illuminate\Http\Request;

class GrupoAntenaController extends Controller
{
    public function index()
    {
        return GrupoAntena::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'idCliente' => 'required|exists:clientes,idCliente',
        ]);
        $grupo = GrupoAntena::create($validated);
        return response()->json($grupo, 201);
    }
}