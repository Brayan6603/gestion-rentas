<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Pago extends Model
{
    use HasFactory;
    protected $table = 'pagos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'monto',
        'fecha_pago',
        'mes_correspondiente',
        'estado',
        'propiedad_id',
        'inquilino_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'date',
        'mes_correspondiente' => 'date',
    ];

    /**
     * Relación: Un pago pertenece a una propiedad
     */
    public function propiedad(){
        return $this->belongsTo(Propiedad::class);
    }

    /**
     * Relación: Un pago pertenece a un inquilino
     */
    public function inquilino(){
        return $this->belongsTo(Inquilino::class);
    }

    
}
