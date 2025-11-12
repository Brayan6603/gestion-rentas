<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquilino extends Model
{
    use HasFactory;

    protected $table = 'inquilinos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'fecha_inicio',
        'fecha_fin',
        'propiedad_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    /**
     * Relación: Un inquilino pertenece a una propiedad
     */
    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class, 'propiedad_id');
    }

    /**
     * Relación: Un inquilino tiene muchos pagos
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'inquilino_id');
    }

    /**
     * Relación: Un inquilino tiene muchos depósitos
     */
    public function depositos()
    {
        return $this->hasMany(Deposito::class, 'inquilino_id');
    }

    /**
     * Obtener el depósito activo del inquilino
     *
     * @return Deposito|null
     */
    public function depositoActivo()
    {
        return $this->depositos()
                    ->where('estado', 'activo')
                    ->first();
    }

    /**
     * Verificar si el inquilino tiene un depósito activo
     *
     * @return bool
     */
    public function tieneDepositoActivo(): bool
    {
        return $this->depositos()
                    ->where('estado', 'activo')
                    ->exists();
    }

    /**
     * Crear un nuevo depósito para el inquilino
     *
     * @param decimal $monto
     * @param date $fecha
     * @param string|null $observaciones
     * @return Deposito
     */
    public function crearDeposito($monto, $fecha, $observaciones = null)
    {
        return $this->depositos()->create([
            'monto' => $monto,
            'fecha_deposito' => $fecha,
            'estado' => 'activo',
            'observaciones' => $observaciones,
            'propiedad_id' => $this->propiedad_id,
        ]);
    }
}
