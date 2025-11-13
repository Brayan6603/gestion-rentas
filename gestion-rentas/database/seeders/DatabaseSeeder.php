<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
                // Ejecutar seeders en orden
                $this->call([
                        //UserSeeder::class,        // Primero usuarios (descomentar si no existen usuarios)
                       // CategoriaGastoSeeder::class, // Categorías de gastos
                       // PropiedadSeeder::class,   // Después propiedades
                        //InquilinoSeeder::class,   // Después inquilinos
                        PagoSeeder::class,        // Luego pagos
                        GastoSeeder::class,       // Luego gastos
                        DepositoSeeder::class,    // Finalmente depósitos
                ]);
    }
}