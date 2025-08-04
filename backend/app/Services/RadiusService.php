<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RadiusService
{
    /**
     * Crea un nuevo código de usuario en las tablas de FreeRADIUS.
     *
     * @param string $username El código de acceso
     * @param string $password La contraseña para el código
     * @param int $expirationInSeconds Tiempo de validez en segundos
     * @param int|null $dataLimitInMB Límite de datos en Megabytes
     */
    public function crearCodigo(string $username, string $password, int $expirationInSeconds, ?int $dataLimitInMB = null)
    {
        // Inserta el usuario y contraseña en la tabla de 'check'
        DB::table('radcheck')->insert([
            'username' => $username,
            'attribute' => 'Cleartext-Password',
            'op' => ':=',
            'value' => $password,
        ]);

        // Inserta la regla de tiempo de expiración en la tabla de 'reply'
        DB::table('radreply')->insert([
            'username' => $username,
            'attribute' => 'Session-Timeout',
            'op' => '=',
            'value' => $expirationInSeconds,
        ]);

        // Si se especifica un límite de datos, lo insertamos también
        if ($dataLimitInMB) {
            $dataLimitInBytes = $dataLimitInMB * 1024 * 1024;
            DB::table('radreply')->insert([
                'username' => $username,
                'attribute' => 'Mikrotik-Total-Limit', // Atributo específico de MikroTik
                'op' => '=',
                'value' => $dataLimitInBytes,
            ]);
        }
    }
}