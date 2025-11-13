<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaGasto extends Model
{
    use HasFactory;

    // El nombre de la tabla coincide con la migración: 'categoria_gastos'
    protected $table = 'categoria_gastos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'color',
    ];

    /**
     * Relación: Una categoría tiene muchos gastos
     */
    public function gastos()
    {
        return $this->hasMany(Gasto::class);
    }
}
