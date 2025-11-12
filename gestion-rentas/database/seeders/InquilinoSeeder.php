<?php

namespace Database\Seeders;

use App\Models\Inquilino;
use App\Models\Propiedad;
use Illuminate\Database\Seeder;

class InquilinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las propiedades existentes
        $propiedades = Propiedad::all();

        // Si no hay propiedades, no crear inquilinos
        if ($propiedades->isEmpty()) {
            $this->command->info('No hay propiedades disponibles. Skipped InquilinoSeeder.');
            return;
        }

        // Datos de inquilinos ficticios
        $inquilinosDatos = [
            [
                'nombre' => 'Juan Carlos López García',
                'email' => 'juan.lopez@email.com',
                'telefono' => '6144556677',
            ],
            [
                'nombre' => 'María Rodríguez Hernández',
                'email' => 'maria.rodriguez@email.com',
                'telefono' => '6144556688',
            ],
            [
                'nombre' => 'Luis Miguel Sánchez',
                'email' => 'luis.sanchez@email.com',
                'telefono' => '6144556699',
            ],
            [
                'nombre' => 'Ana Martínez Flores',
                'email' => 'ana.martinez@email.com',
                'telefono' => '6144556700',
            ],
            [
                'nombre' => 'Carlos Antonio Díaz',
                'email' => 'carlos.diaz@email.com',
                'telefono' => '6144556711',
            ],
            [
                'nombre' => 'Patricia González Ruiz',
                'email' => 'patricia.gonzalez@email.com',
                'telefono' => '6144556722',
            ],
            [
                'nombre' => 'Roberto Morales Castillo',
                'email' => 'roberto.morales@email.com',
                'telefono' => '6144556733',
            ],
            [
                'nombre' => 'Silvia Ramirez Mendez',
                'email' => 'silvia.ramirez@email.com',
                'telefono' => '6144556744',
            ],
            [
                'nombre' => 'Fernando Jiménez Reyes',
                'email' => 'fernando.jimenez@email.com',
                'telefono' => '6144556755',
            ],
            [
                'nombre' => 'Elizabeth Vázquez Silva',
                'email' => 'elizabeth.vazquez@email.com',
                'telefono' => '6144556766',
            ],
        ];

        // Crear inquilinos distribuidos entre propiedades
        foreach ($inquilinosDatos as $index => $datos) {
            // Distribuir inquilinos entre propiedades
            $propiedad = $propiedades[$index % $propiedades->count()];

            Inquilino::create([
                'nombre' => $datos['nombre'],
                'email' => $datos['email'],
                'telefono' => $datos['telefono'],
                'fecha_inicio' => now()->subMonths(rand(1, 12))->startOfMonth(),
                'fecha_fin' => rand(0, 1) ? now()->addMonths(rand(1, 12)) : null,
                'propiedad_id' => $propiedad->id,
            ]);
        }

        $this->command->info('✅ InquilinoSeeder completado: ' . count($inquilinosDatos) . ' inquilinos creados.');
    }
}
