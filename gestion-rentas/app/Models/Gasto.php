<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
     use HasFactory;

    protected $fillable = [
        'concepto',
        'monto',
        'fecha_gasto',
        'descripcion',
        'propiedad_id',
        'categoria_gasto_id',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_gasto' => 'date',
    ];

    /**
     * Relación: Un gasto pertenece a una propiedad
     */
    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class);
    }

    /**
     * Relación: Un gasto pertenece a una categoría
     */
    public function categoria()
    {
        return $this->belongsTo(CategoriaGasto::class, 'categoria_gasto_id');
    }

}
