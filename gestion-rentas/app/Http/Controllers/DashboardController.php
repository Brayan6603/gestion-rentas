<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use App\Models\Inquilino;
use App\Models\Pago;
use App\Models\Deposito;
use App\Models\Gasto;
use App\Models\CategoriaGasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Conteo de entidades del usuario
        $propiedadesCount = $user->propiedades()->count();
        $propiedadesActivas = $user->propiedades()->where('estado', 'rentada')->count();
        $propiedadesDisponibles = $user->propiedades()->where('estado', 'disponible')->count();
        
        $inquilinosCount = Inquilino::whereHas('propiedad', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        
        // Count active tenants (those with fecha_fin in the future or null)
        $inquilinosActivos = Inquilino::whereHas('propiedad', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where(function($q) {
            $q->whereNull('fecha_fin')
              ->orWhere('fecha_fin', '>=', now());
        })->count();
        
        $pagosCount = Pago::whereHas('propiedad', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        
        $depositosCount = Deposito::whereHas('propiedad', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        
        $gastosCount = Gasto::whereHas('propiedad', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        
        // Métricas financieras del mes actual
        $mesActual = now()->format('Y-m');
        
        $ingresosMes = Pago::whereHas('propiedad', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->whereYear('fecha_pago', now()->year)
        ->whereMonth('fecha_pago', now()->month)
        ->sum('monto');
        
        $gastosMes = Gasto::whereHas('propiedad', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->whereYear('fecha_gasto', now()->year)
        ->whereMonth('fecha_gasto', now()->month)
        ->sum('monto');
        
        $balanceMes = $ingresosMes - $gastosMes;
        
        // Depósitos activos
        $depositosActivos = Deposito::whereHas('propiedad', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->where('estado', 'activo')
        ->sum('monto');
        
        // Últimos pagos
        $ultimosPagos = Pago::with(['propiedad', 'inquilino'])
            ->whereHas('propiedad', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->orderByDesc('fecha_pago')
            ->limit(5)
            ->get();
        
        // Últimos gastos
        $ultimosGastos = Gasto::with(['propiedad', 'categoria'])
            ->whereHas('propiedad', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->orderByDesc('fecha_gasto')
            ->limit(5)
            ->get();
        
        // Próximos vencimientos de renta (inquilinos activos)
        $proximosVencimientos = Inquilino::with('propiedad')
            ->whereHas('propiedad', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where(function($q) {
                $q->whereNull('fecha_fin')
                  ->orWhere('fecha_fin', '>=', now());
            })
            ->orderBy('fecha_inicio')
            ->limit(5)
            ->get();
        
        // Gastos por categoría este mes
        $gastosPorCategoria = Gasto::with('categoria')
            ->whereHas('propiedad', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->whereYear('fecha_gasto', now()->year)
            ->whereMonth('fecha_gasto', now()->month)
            ->select('categoria_gasto_id', DB::raw('SUM(monto) as total'))
            ->groupBy('categoria_gasto_id')
            ->get();
        
        // Propiedades con más gastos
        $propiedadesConMasGastos = Propiedad::with('gastos')
            ->where('user_id', $user->id)
            ->withSum(['gastos' => function($q) {
                $q->whereYear('fecha_gasto', now()->year)
                  ->whereMonth('fecha_gasto', now()->month);
            }], 'monto')
            ->orderByDesc('gastos_sum_monto')
            ->limit(5)
            ->get();
        
        return view('dashboard', compact(
            'propiedadesCount',
            'propiedadesActivas',
            'propiedadesDisponibles',
            'inquilinosCount',
            'inquilinosActivos',
            'pagosCount',
            'depositosCount',
            'gastosCount',
            'ingresosMes',
            'gastosMes',
            'balanceMes',
            'depositosActivos',
            'ultimosPagos',
            'ultimosGastos',
            'proximosVencimientos',
            'gastosPorCategoria',
            'propiedadesConMasGastos'
        ));
    }
}
