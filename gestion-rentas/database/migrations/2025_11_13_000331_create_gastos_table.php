<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->string('concepto');
            $table->decimal('monto', 10, 2);
            $table->date('fecha_gasto');
            $table->text('descripcion')->nullable();
            $table->foreignId('propiedad_id')->constrained('propiedades')->onDelete('cascade');
            $table->foreignId('categoria_gasto_id')->constrained('categoria_gastos')->onDelete('cascade');
            $table->timestamps();

            // Índices
            $table->index('fecha_gasto');
            $table->index('categoria_gasto_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('gastos');
    }
};
