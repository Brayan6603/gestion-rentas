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
            //UserSeeder::class,        // Primero usuarios
          //  CategoriaGastoSeeder::class, // Luego categorías de gastos
            PropiedadSeeder::class,   // Después propiedades
            InquilinoSeeder::class,   // Después inquilinos
            // PagoSeeder::class,       // Luego pagos (cuando exista)
            // GastoSeeder::class,      // Luego gastos (cuando exista)
            // DepositoSeeder::class,   // Finalmente depósitos (cuando exista)
        ]);
    }
}