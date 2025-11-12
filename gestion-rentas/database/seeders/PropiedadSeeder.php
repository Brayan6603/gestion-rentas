<?php

namespace Database\Seeders;

use App\Models\Propiedad;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropiedadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el usuario administrador
        $user = User::first();

        if (!$user) {
            $this->command->error('No se encontró ningún usuario. Ejecuta primero el DatabaseSeeder.');
            return;
        }

        $propiedades = [
            [
                'nombre' => 'Departamento 101 - Centro',
                'direccion' => 'Av. Reforma #123, Col. Centro, Río Grande, Zacatecas',
                'renta_mensual' => 3500.00,
                'descripcion' => 'Departamento amplio en zona céntrica, 2 recámaras, 1 baño, cocina integral, estacionamiento incluido.',
                'tipo' => 'departamento',
                'estado' => 'rentada',
                'user_id' => $user->id,
            ],
            [
                'nombre' => 'Departamento 205 - Jardines',
                'direccion' => 'Calle Jardín #45, Col. Jardines del Valle, Río Grande, Zacatecas',
                'renta_mensual' => 4200.00,
                'descripcion' => 'Departamento moderno con acabados de lujo, 2 recámaras, 2 baños, balcón, amenidades.',
                'tipo' => 'departamento',
                'estado' => 'disponible',
                'user_id' => $user->id,
            ],
            [
                'nombre' => 'Casa Familiar - San Francisco',
                'direccion' => 'Privada San Francisco #78, Col. San Francisco, Río Grande, Zacatecas',
                'renta_mensual' => 5500.00,
                'descripcion' => 'Casa familiar con jardín, 3 recámaras, 2 baños, cocina amplia, patio trasero, cochera para 2 autos.',
                'tipo' => 'casa',
                'estado' => 'rentada',
                'user_id' => $user->id,
            ],
            [
                'nombre' => 'Local Comercial - Plaza Central',
                'direccion' => 'Plaza Central Local 12, Av. Principal, Río Grande, Zacatecas',
                'renta_mensual' => 6800.00,
                'descripcion' => 'Local comercial en plaza con alto flujo de personas, ideal para negocio, 45m², baño, vitrina.',
                'tipo' => 'local',
                'estado' => 'disponible',
                'user_id' => $user->id,
            ],
            [
                'nombre' => 'Departamento 304 - Vista Hermosa',
                'direccion' => 'Calle Vista Hermosa #234, Col. Lomas del Sol, Río Grande, Zacatecas',
                'renta_mensual' => 3800.00,
                'descripcion' => 'Departamento con vista panorámica, 1 recámara, 1 baño, cocina pequeña, perfecto para soltero/a.',
                'tipo' => 'departamento',
                'estado' => 'rentada',
                'user_id' => $user->id,
            ],
            [
                'nombre' => 'Casa Económica - Barrio Antiguo',
                'direccion' => 'Calle Hidalgo #67, Col. Centro Histórico, Río Grande, Zacatecas',
                'renta_mensual' => 3200.00,
                'descripcion' => 'Casa tradicional remodelada, 2 recámaras, 1 baño, patio interior, cerca de servicios.',
                'tipo' => 'casa',
                'estado' => 'disponible',
                'user_id' => $user->id,
            ],
            [
                'nombre' => 'Departamento 102 - Residencial Campestre',
                'direccion' => 'Residencial Campestre #89, Col. Campestre, Río Grande, Zacatecas',
                'renta_mensual' => 4800.00,
                'descripcion' => 'Departamento en zona residencial tranquila, 2 recámaras, 2 baños, área de lavado, seguridad 24/7.',
                'tipo' => 'departamento',
                'estado' => 'rentada',
                'user_id' => $user->id,
            ],
            [
                'nombre' => 'Local Pequeño - Mercado Municipal',
                'direccion' => 'Mercado Municipal Local 5, Zona Centro, Río Grande, Zacatecas',
                'renta_mensual' => 2500.00,
                'descripcion' => 'Local pequeño dentro del mercado municipal, ideal para venta de alimentos o productos locales.',
                'tipo' => 'local',
                'estado' => 'disponible',
                'user_id' => $user->id,
            ],
            [
                'nombre' => 'Casa Duplex - Zona Norte',
                'direccion' => 'Av. del Norte #156, Col. Norte, Río Grande, Zacatecas',
                'renta_mensual' => 6000.00,
                'descripcion' => 'Casa dúplex, planta baja: sala, cocina, baño; planta alta: 2 recámaras, baño, terraza.',
                'tipo' => 'casa',
                'estado' => 'rentada',
                'user_id' => $user->id,
            ],
            [
                'nombre' => 'Departamento 401 - Torre Diamante',
                'direccion' => 'Torre Diamante Piso 4, Av. Moderna, Río Grande, Zacatecas',
                'renta_mensual' => 5200.00,
                'descripcion' => 'Departamento en edificio moderno, 3 recámaras, 2 baños, cocina equipada, gimnasio, alberca.',
                'tipo' => 'departamento',
                'estado' => 'disponible',
                'user_id' => $user->id,
            ]
        ];

        // Insertar propiedades
        foreach ($propiedades as $propiedad) {
            Propiedad::create($propiedad);
        }

        $this->command->info('✅ 10 propiedades de ejemplo creadas exitosamente.');
        $this->command->info('📊 Resumen:');
        $this->command->info('   - Departamentos: 6');
        $this->command->info('   - Casas: 3');
        $this->command->info('   - Locales: 2');
        $this->command->info('   - Disponibles: 5');
        $this->command->info('   - Rentadas: 5');
    }
}