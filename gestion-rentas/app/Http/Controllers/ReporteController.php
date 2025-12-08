<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use App\Models\Pago;
use App\Models\Gasto;
use App\Models\Deposito;
use App\Models\Inquilino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function balanceGeneral(Request $request)
    {
        $user = auth()->user();

        $propiedades = $user->propiedades()->with(['pagos', 'gastos'])->get();

        $resumen = $propiedades->map(function ($propiedad) {
            $totalPagos = $propiedad->pagos->sum('monto');
            $totalGastos = $propiedad->gastos->sum('monto');
            $balance = $totalPagos - $totalGastos;

            return [
                'propiedad' => $propiedad,
                'total_pagos' => $totalPagos,
                'total_gastos' => $totalGastos,
                'balance' => $balance,
            ];
        });

        $totales = [
            'pagos' => $resumen->sum('total_pagos'),
            'gastos' => $resumen->sum('total_gastos'),
            'balance' => $resumen->sum('balance'),
        ];

        return view('reportes.balance-general', compact('resumen', 'totales'));
    }

    public function estadoCuenta(Request $request)
    {
        $user = auth()->user();

        $propiedadId = $request->get('propiedad_id');
        $propiedad = null;
        $pagos = collect();
        $gastos = collect();

        $propiedades = $user->propiedades()->orderBy('nombre')->get();

        if ($propiedadId) {
            $propiedad = $user->propiedades()->findOrFail($propiedadId);

            $pagos = $propiedad->pagos()->orderByDesc('fecha_pago')->get();
            $gastos = $propiedad->gastos()->orderByDesc('fecha_gasto')->get();
        }

        return view('reportes.estado-cuenta', compact('propiedades', 'propiedad', 'pagos', 'gastos'));
    }

    public function mensual(Request $request)
    {
        $user = auth()->user();

        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $propiedadId = $request->get('propiedad_id');

        // Propiedades del usuario para el filtro
        $propiedades = $user->propiedades()->orderBy('nombre')->get();

        $pagosQuery = Pago::whereHas('propiedad', function ($q) use ($user, $propiedadId) {
                $q->where('user_id', $user->id);

                if ($propiedadId) {
                    $q->where('id', $propiedadId);
                }
            })
            ->whereYear('fecha_pago', $year)
            ->whereMonth('fecha_pago', $month);

        $pagos = $pagosQuery->sum('monto');

        $gastosQuery = Gasto::whereHas('propiedad', function ($q) use ($user, $propiedadId) {
                $q->where('user_id', $user->id);

                if ($propiedadId) {
                    $q->where('id', $propiedadId);
                }
            })
            ->whereYear('fecha_gasto', $year)
            ->whereMonth('fecha_gasto', $month);

        $gastos = $gastosQuery->sum('monto');

        $balance = $pagos - $gastos;

        $detallesPagos = Pago::with('propiedad')
            ->whereHas('propiedad', function ($q) use ($user, $propiedadId) {
                $q->where('user_id', $user->id);

                if ($propiedadId) {
                    $q->where('id', $propiedadId);
                }
            })
            ->whereYear('fecha_pago', $year)
            ->whereMonth('fecha_pago', $month)
            ->orderByDesc('fecha_pago')
            ->get();

        $detallesGastos = Gasto::with('propiedad', 'categoria')
            ->whereHas('propiedad', function ($q) use ($user, $propiedadId) {
                $q->where('user_id', $user->id);

                if ($propiedadId) {
                    $q->where('id', $propiedadId);
                }
            })
            ->whereYear('fecha_gasto', $year)
            ->whereMonth('fecha_gasto', $month)
            ->orderByDesc('fecha_gasto')
            ->get();

        return view('reportes.mensual', compact(
            'year',
            'month',
            'propiedadId',
            'propiedades',
            'pagos',
            'gastos',
            'balance',
            'detallesPagos',
            'detallesGastos'
        ));
    }

    public function anual(Request $request)
    {
        $user = auth()->user();

        $year = $request->get('year', now()->year);

        $ingresosPorMes = Pago::whereHas('propiedad', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->whereYear('fecha_pago', $year)
            ->selectRaw('MONTH(fecha_pago) as mes, SUM(monto) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        $gastosPorMes = Gasto::whereHas('propiedad', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->whereYear('fecha_gasto', $year)
            ->selectRaw('MONTH(fecha_gasto) as mes, SUM(monto) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        $meses = collect(range(1, 12))->map(function ($mes) use ($ingresosPorMes, $gastosPorMes) {
            $ingresos = $ingresosPorMes[$mes] ?? 0;
            $gastos = $gastosPorMes[$mes] ?? 0;

            return [
                'mes' => $mes,
                'ingresos' => $ingresos,
                'gastos' => $gastos,
                'balance' => $ingresos - $gastos,
            ];
        });

        $totales = [
            'ingresos' => $meses->sum('ingresos'),
            'gastos' => $meses->sum('gastos'),
            'balance' => $meses->sum('balance'),
        ];

        return view('reportes.anual', compact('year', 'meses', 'totales'));
    }
}
