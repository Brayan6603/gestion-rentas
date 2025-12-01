<?php

namespace App\Console\Commands;

use App\Models\Propiedad;
use Illuminate\Console\Command;



class GenerarPagosPendientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pagos:generar-pendientes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera pagos pendientes para el mes actual en todas las propiedades rentadas con inquilino activo.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generando pagos pendientes para el mes actual...');

        $propiedades = Propiedad::rentadas()->get();
        $totalCreados = 0;

        foreach ($propiedades as $propiedad) {
            $pago = $propiedad->asegurarPagoPendienteMesActual();

            if ($pago && $pago->wasRecentlyCreated) {
                $totalCreados++;
                $this->line("Pago pendiente creado para la propiedad #{$propiedad->id} ({$propiedad->nombre}).");
            }
        }

        $this->info("Proceso finalizado. Pagos pendientes creados: {$totalCreados}.");

        return Command::SUCCESS;
    }
}
