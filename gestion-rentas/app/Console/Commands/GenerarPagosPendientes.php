<?php

namespace App\Console\Commands;

use App\Models\Pago;
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
    protected $description = 'Genera pagos pendientes para el mes actual y actualiza el estado de pagos vencidos.';

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

        $this->info("Pagos pendientes creados para el mes actual: {$totalCreados}.");

        // Actualizar pagos vencidos: pagos que no están pagados ni parciales
        // y cuya fecha límite (fin de mes correspondiente + 3 días) ya pasó.
        $this->info('Actualizando pagos vencidos...');

        $hoy = now();

        $pagosVencidos = Pago::whereIn('estado', ['pendiente'])
            ->whereDate(
                // fecha límite = fin de mes correspondiente + 3 días
                // usamos mes_correspondiente como primer día del mes
                'mes_correspondiente',
                '<=',
                $hoy->copy()->subDays(3)->startOfMonth()
            )
            ->update(['estado' => 'vencido']);

        $this->info("Pagos marcados como vencidos: {$pagosVencidos}.");

        return Command::SUCCESS;
    }
}
