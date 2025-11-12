<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador principal
        User::create([
            'name' => 'Admin123',
            'email' => 'admin@correo.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Usuario administrador creado:');
        $this->command->info('   📧 Email:');
        $this->command->info('   🔑 Password');
    }
}