<?php

namespace Database\Seeders;

use App\Models\Gasto;
use App\Models\Propiedad;
use App\Models\CategoriaGasto;
use Illuminate\Database\Seeder;

class GastoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $propiedades = Propiedad::all();
        $categorias = CategoriaGasto::all();

        if ($propiedades->isEmpty() || $categorias->isEmpty()) {
            $this->command->info('Faltan propiedades o categorías. Skipped GastoSeeder.');
            return;
        }

        $conceptos = [
            'Reparación de tubería',
            'Pago de agua',
            'Pago de luz',
            'Limpieza de áreas comunes',
            'Compra de materiales',
            'Servicio de jardinería',
            'Seguro de inmueble',
            'Reparación de puerta',
            'Cambio de cerradura',
            'Mantenimiento general'
        ];

        $count = 0;

        foreach ($propiedades as $propiedad) {
            // Crear entre 1 y 4 gastos por propiedad
            $num = rand(1, 4);
            for ($i = 0; $i < $num; $i++) {
                $concepto = $conceptos[array_rand($conceptos)];
                $monto = rand(200, 5000);
                $fecha = now()->subDays(rand(1, 180));
                $categoria = $categorias->random();

                Gasto::create([
                    'concepto' => $concepto,
                    'monto' => $monto,
                    'fecha_gasto' => $fecha->format('Y-m-d'),
                    'descripcion' => 'Gasto generado por seeder: ' . $concepto,
                    'propiedad_id' => $propiedad->id,
                    'categoria_gasto_id' => $categoria->id,
                ]);

                $count++;
            }
        }

        $this->command->info("✅ GastoSeeder completado: $count gastos creados.");
    }
}
