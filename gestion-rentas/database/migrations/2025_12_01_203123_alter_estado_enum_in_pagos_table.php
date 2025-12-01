<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ampliar el enum de la columna estado para incluir 'parcial'
        DB::statement("ALTER TABLE pagos MODIFY estado ENUM('pendiente','pagado','parcial','vencido') NOT NULL DEFAULT 'pendiente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Volver al enum anterior sin 'parcial'
        DB::statement("ALTER TABLE pagos MODIFY estado ENUM('pendiente','pagado','vencido') NOT NULL DEFAULT 'pendiente'");
    }
};
