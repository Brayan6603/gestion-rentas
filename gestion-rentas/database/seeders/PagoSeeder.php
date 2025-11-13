<?php

namespace Database\Seeders;

use App\Models\Pago;
use App\Models\Inquilino;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inquilinos = Inquilino::with('propiedad')->get();

        if ($inquilinos->isEmpty()) {
            $this->command->info('No hay inquilinos. Skipped PagoSeeder.');
            return;
        }

        $count = 0;

        foreach ($inquilinos as $inquilino) {
            // Crear 3 pagos recientes por inquilino
            for ($i = 0; $i < 3; $i++) {
                $mes = now()->subMonths($i)->startOfMonth();

                $monto = $inquilino->propiedad->renta_mensual ?? rand(3000, 6000);

                // Asignar estado aleatorio con más probabilidad de 'pagado'
                $rand = rand(1, 100);
                if ($rand <= 70) {
                    $estado = 'pagado';
                } elseif ($rand <= 85) {
                    $estado = 'vencido';
                } else {
                    $estado = 'pendiente';
                }

                $fecha_pago = $mes->copy()->addDays(rand(1, 28));

                Pago::create([
                    'monto' => $monto,
                    'fecha_pago' => $fecha_pago->format('Y-m-d'),
                    'mes_correspondiente' => $mes->format('Y-m-d'),
                    'estado' => $estado,
                    'propiedad_id' => $inquilino->propiedad->id,
                    'inquilino_id' => $inquilino->id,
                ]);

                $count++;
            }
        }

        $this->command->info("✅ PagoSeeder completado: $count pagos creados.");
    }
}
