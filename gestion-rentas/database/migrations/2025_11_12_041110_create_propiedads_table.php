<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('propiedades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('direccion');
            $table->decimal('renta_mensual', 10, 2);
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['departamento', 'casa', 'local'])->default('departamento');
            $table->enum('estado', ['disponible', 'rentada'])->default('disponible');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Índices
            $table->index('user_id');
            $table->index('estado');
        });
    }

    public function down()
    {
        Schema::dropIfExists('propiedades');
    }
};