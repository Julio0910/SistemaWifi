<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MonitorAntenas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'antenas:monitor';


    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Monitorea el estado de las antenas y actualiza la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $this->info('Iniciando monitoreo de antenas...');

    $antenas = \App\Models\Antena::all();

    foreach ($antenas as $antena) {
        // Ejecutamos el comando 'ping' del sistema operativo
        exec("ping -c 1 " . $antena->ip, $output, $result);

        if ($result == 0) {
            // Si el resultado es 0, el ping fue exitoso
            $antena->estado = 'online';
            $this->info("Antena '{$antena->nombre}' ({$antena->ip}) está online.");
        } else {
            // Si el resultado es diferente de 0, el ping falló
            $antena->estado = 'offline';
            $this->warn("Antena '{$antena->nombre}' ({$antena->ip}) está offline.");
        }
        $antena->save();
    }

    $this->info('Monitoreo de antenas finalizado.');
    return 0;
}
}
