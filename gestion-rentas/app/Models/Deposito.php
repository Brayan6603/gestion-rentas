<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'monto',
        'fecha_deposito',
        'fecha_devolucion',
        'estado',
        'monto_devuelto',
        'observaciones',
        'concepto_retencion',
        'inquilino_id',
        'propiedad_id',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'monto_devuelto' => 'decimal:2',
        'fecha_deposito' => 'date',
        'fecha_devolucion' => 'date',
    ];

    /**
     * Relación: Un depósito pertenece a un inquilino
     */
    public function inquilino()
    {
        return $this->belongsTo(Inquilino::class);
    }

    /**
     * Relación: Un depósito pertenece a una propiedad
     */
    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class);
    }

}
