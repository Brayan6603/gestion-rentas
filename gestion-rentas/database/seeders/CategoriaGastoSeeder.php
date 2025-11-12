<?php

namespace Database\Seeders;

use App\Models\CategoriaGasto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaGastoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Mantenimiento',
                'descripcion' => 'Reparaciones y mantenimiento general de las propiedades',
                'color' => '#FF6B6B'
            ],
            [
                'nombre' => 'Servicios',
                'descripcion' => 'Agua, luz, gas, internet y otros servicios básicos',
                'color' => '#4ECDC4'
            ],
            [
                'nombre' => 'Impuestos',
                'descripcion' => 'Impuestos prediales y diversos de las propiedades',
                'color' => '#45B7D1'
            ],
            [
                'nombre' => 'Limpieza',
                'descripcion' => 'Servicios de limpieza y aseo de las propiedades',
                'color' => '#96CEB4'
            ],
            [
                'nombre' => 'Seguros',
                'descripcion' => 'Pólizas de seguro de las propiedades',
                'color' => '#FFEAA7'
            ],
            [
                'nombre' => 'Administración',
                'descripcion' => 'Gastos administrativos varios',
                'color' => '#DDA0DD'
            ],
            [
                'nombre' => 'Mejoras',
                'descripcion' => 'Mejoras y remodelaciones de las propiedades',
                'color' => '#98D8C8'
            ],
            [
                'nombre' => 'Otros',
                'descripcion' => 'Otros gastos varios no categorizados',
                'color' => '#F7DC6F'
            ]
        ];

        foreach ($categorias as $categoria) {
            CategoriaGasto::create($categoria);
        }

        $this->command->info('✅ 8 categorías de gastos creadas exitosamente.');
    }
}