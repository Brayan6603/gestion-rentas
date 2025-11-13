<?php

namespace Database\Seeders;

use App\Models\Deposito;
use App\Models\Inquilino;
use Illuminate\Database\Seeder;

class DepositoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inquilinos = Inquilino::with('propiedad')->get();

        if ($inquilinos->isEmpty()) {
            $this->command->info('No hay inquilinos. Skipped DepositoSeeder.');
            return;
        }

        $count = 0;

        foreach ($inquilinos as $inquilino) {
            // Solo algunos inquilinos tienen depósito (60%)
            if (rand(1, 100) > 60) {
                continue;
            }

            $monto = $inquilino->propiedad->renta_mensual ?? rand(3000, 6000);
            $fecha_deposito = now()->subMonths(rand(1, 12))->startOfMonth()->addDays(rand(1, 25));

            // Estado aleatorio con mayor probabilidad de 'activo'
            $rand = rand(1, 100);
            if ($rand <= 65) {
                $estado = 'activo';
                $monto_devuelto = 0;
                $fecha_devolucion = null;
                $concepto_retencion = null;
            } elseif ($rand <= 80) {
                $estado = 'devuelto';
                $monto_devuelto = $monto;
                $fecha_devolucion = $fecha_deposito->copy()->addMonths(rand(1, 12));
                $concepto_retencion = null;
            } elseif ($rand <= 90) {
                $estado = 'parcialmente_devuelto';
                $monto_devuelto = round($monto * (rand(10, 70) / 100), 2);
                $fecha_devolucion = $fecha_deposito->copy()->addMonths(rand(1, 8));
                $concepto_retencion = 'Retención por daños menores';
            } else {
                $estado = 'retenido';
                $monto_devuelto = 0;
                $fecha_devolucion = null;
                $concepto_retencion = 'Retención por adeudo de servicios';
            }

            Deposito::create([
                'monto' => $monto,
                'fecha_deposito' => $fecha_deposito->format('Y-m-d'),
                'fecha_devolucion' => $fecha_devolucion?->format('Y-m-d'),
                'estado' => $estado,
                'monto_devuelto' => $monto_devuelto,
                'observaciones' => 'Depósito generado por seeder',
                'concepto_retencion' => $concepto_retencion,
                'inquilino_id' => $inquilino->id,
                'propiedad_id' => $inquilino->propiedad->id,
            ]);

            $count++;
        }

        $this->command->info("✅ DepositoSeeder completado: $count depósitos creados.");
    }
}
