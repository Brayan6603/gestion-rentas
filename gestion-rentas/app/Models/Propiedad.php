<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    use HasFactory;

    protected $table = 'propiedades';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'direccion',
        'renta_mensual',
        'descripcion',
        'tipo',
        'estado',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'renta_mensual' => 'decimal:2',
        'fecha_creacion' => 'datetime',
    ];

    /**
     * Relación: Una propiedad pertenece a un usuario (administrador)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación: Una propiedad tiene muchos inquilinos
     */
    public function inquilinos()
    {
        return $this->hasMany(Inquilino::class, 'propiedad_id');
    }

    /**
     * Relación: Una propiedad tiene muchos pagos
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    /**
     * Relación: Una propiedad tiene muchos gastos
     */
    public function gastos()
    {
        return $this->hasMany(Gasto::class);
    }

    /**
     * Relación: Una propiedad tiene muchos depósitos
     */
    public function depositos()
    {
        return $this->hasMany(Deposito::class);
    }

    /**
     * Scope para propiedades disponibles
     */
    public function scopeDisponibles($query)
    {
        return $query->where('estado', 'disponible');
    }

    /**
     * Scope para propiedades rentadas
     */
    public function scopeRentadas($query)
    {
        return $query->where('estado', 'rentada');
    }

    /**
     * Obtener el inquilino actual (si existe)
     */
    public function inquilinoActual()
    {
        return $this->inquilinos()
            ->where(function ($query) {
                $query->where('fecha_fin', '>=', now())
                    ->orWhereNull('fecha_fin');
            })
            ->first();
    }

    /**
     * Crear (si no existe) el pago pendiente del mes actual
     * para esta propiedad y su inquilino actual.
     */
    public function asegurarPagoPendienteMesActual()
    {
        $inquilinoActual = $this->inquilinoActual();

        if (! $inquilinoActual) {
            return null;
        }

        $mesInicio = now()->startOfMonth();

        $pagoExistente = $this->pagos()
            ->whereDate('mes_correspondiente', $mesInicio)
            ->where('inquilino_id', $inquilinoActual->id)
            ->first();

        if ($pagoExistente) {
            return $pagoExistente;
        }

        return $this->pagos()->create([
            'monto' => $this->renta_mensual,
            // Para pagos pendientes usamos la fecha del mes correspondiente
            // como fecha_pago inicial para cumplir la restricción NOT NULL.
            'fecha_pago' => $mesInicio,
            'mes_correspondiente' => $mesInicio,
            'estado' => 'pendiente',
            'inquilino_id' => $inquilinoActual->id,
        ]);
    }

    /**
     * Calcular el depósito sugerido (1 mes de renta)
     */
    public function getDepositoSugeridoAttribute()
    {
        return $this->renta_mensual;
    }

    /**
     * Calcular el total de depósitos activos
     */
    public function totalDepositosActivos()
    {
        return $this->depositos()->where('estado', 'activo')->sum('monto');
    }

    /**
     * Verificar si la propiedad está disponible
     */
    public function getEstaDisponibleAttribute()
    {
        return $this->estado === 'disponible';
    }

    /**
     * Obtener los pagos pendientes de la propiedad
     */
    public function pagosPendientes()
    {
        return $this->pagos()->where('estado', 'pendiente')->get();
    }

    /**
     * Obtener los gastos del mes actual
     */
    public function gastosDelMes()
    {
        return $this->gastos()
            ->whereYear('fecha_gasto', now()->year)
            ->whereMonth('fecha_gasto', now()->month)
            ->get();
    }

    /**
     * Calcular el balance del mes (ingresos - gastos)
     */
    public function balanceMensual()
    {
        $ingresos = $this->pagos()
            ->where('estado', 'pagado')
            ->whereYear('fecha_pago', now()->year)
            ->whereMonth('fecha_pago', now()->month)
            ->sum('monto');

        $gastos = $this->gastos()
            ->whereYear('fecha_gasto', now()->year)
            ->whereMonth('fecha_gasto', now()->month)
            ->sum('monto');

        return $ingresos - $gastos;
    }
}