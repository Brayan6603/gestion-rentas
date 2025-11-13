<?php
// database/migrations/2024_10_xxxxxx_create_depositos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('depositos', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 10, 2);
            $table->date('fecha_deposito');
            $table->date('fecha_devolucion')->nullable();
            $table->enum('estado', ['activo', 'devuelto', 'retenido', 'parcialmente_devuelto'])->default('activo');
            $table->decimal('monto_devuelto', 10, 2)->default(0);
            $table->text('observaciones')->nullable();
            $table->text('concepto_retencion')->nullable();
            $table->foreignId('inquilino_id')->constrained()->onDelete('cascade');
            $table->foreignId('propiedad_id')->constrained('propiedades')->onDelete('cascade');
            $table->timestamps();
            
            // Índices para optimización
            $table->index(['inquilino_id', 'estado']);
            $table->index(['propiedad_id', 'estado']);
            $table->index('estado');
            $table->index('fecha_deposito');
        });
    }

    public function down()
    {
        Schema::dropIfExists('depositos');
    }
};