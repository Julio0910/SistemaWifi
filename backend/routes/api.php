<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\GrupoAntenaController;
use App\Http\Controllers\AntenaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;


Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('/clientes', ClienteController::class);

Route::apiResource('/eventos', EventoController::class);

Route::apiResource('/salones', SalonController::class);

Route::apiResource('/grupos-antena', GrupoAntenaController::class);

Route::apiResource('/antenas', AntenaController::class);

Route::post('/eventos/{evento}/generar-codigos', [App\Http\Controllers\EventoController::class, 'generarCodigos']);

Route::middleware('auth:sanctum')->post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/dashboard-stats', [DashboardController::class, 'getStats']);

