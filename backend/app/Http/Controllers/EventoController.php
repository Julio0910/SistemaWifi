<?php

namespace App\Http\Controllers;

use App\Services\RadiusService;
use Illuminate\Support\Str;
use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    // Muestra todos los eventos
    public function index()
    {
        return response()->json(Evento::with('cliente')->get());
    }
    
    // Guarda un nuevo evento
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date|after_or_equal:fechaInicio',
            'asistentesEstimados' => 'required|integer',
            'idCliente' => 'required|exists:clientes,idCliente',
        ]);

        $evento = Evento::create($validatedData);
        return response()->json($evento, 201);
    }

    // Muestra un evento específico
    public function show(Evento $evento)
    {
        return response()->json($evento->load('cliente'));
    }

    // Actualiza un evento
    public function update(Request $request, Evento $evento)
    {
        $validatedData = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'fechaInicio' => 'sometimes|required|date',
            'fechaFin' => 'sometimes|required|date|after_or_equal:fechaInicio',
            'asistentesEstimados' => 'sometimes|required|integer',
            'idCliente' => 'sometimes|required|exists:clientes,idCliente',
        ]);

        $evento->update($validatedData);
        return response()->json($evento);
    }

    // Elimina un evento
    public function destroy(Evento $evento)
    {
        $evento->delete();
        return response()->noContent();
    }
    /**
     * Genera códigos WiFi para un evento específico.
     */
    public function generarCodigos(Request $request, Evento $evento, RadiusService $radiusService)
    {
        $validated = $request->validate([
            'cantidad' => 'required|integer|min:1|max:500',
            'duracion_horas' => 'required|integer|min:1',
            'limite_mb' => 'nullable|integer|min:10',
        ]);

        $codigosGenerados = [];
        $tiempoExpiracion = $validated['duracion_horas'] * 3600; // Convertir horas a segundos

        for ($i = 0; $i < $validated['cantidad']; $i++) {
            // Generamos un código aleatorio de 6 caracteres
            $codigo = Str::random(6);

            // Usamos nuestro RadiusService para crear el código
            $radiusService->crearCodigo(
                $codigo,
                $codigo, // Usamos el mismo código como contraseña
                $tiempoExpiracion,
                $validated['limite_mb'] ?? null
            );

            $codigosGenerados[] = $codigo;
        }

        return response()->json([
            'message' => 'Códigos generados exitosamente para el evento: ' . $evento->nombre,
            'codigos' => $codigosGenerados,
        ]);
    }
}