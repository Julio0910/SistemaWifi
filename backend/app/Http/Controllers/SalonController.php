<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    public function index()
    {
        return Salon::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'idCliente' => 'required|exists:clientes,idCliente',
            'capacidad' => 'nullable|integer',
        ]);
        $salon = Salon::create($validated);
        return response()->json($salon, 201);
    }
}