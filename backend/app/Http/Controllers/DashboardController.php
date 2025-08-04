<?php

namespace App\Http\Controllers;

use App\Models\Antena;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getStats()
{
    $eventosActivos = \App\Models\Evento::where('fechaInicio', '<=', now())
                                      ->where('fechaFin', '>=', now())
                                      ->count();

    $antenasActivas = \App\Models\Antena::where('estado', 'online')->count();

    // Estos valores los implementaremos en el futuro.
    $codigosHoy = 0;
    $consumoTotalGB = 0;

    return response()->json([
        'eventos_activos' => $eventosActivos,
        'antenas_activas' => $antenasActivas,
        'codigos_generados_hoy' => $codigosHoy,
        'consumo_total_gb' => $consumoTotalGB,
    ]);
}
}