@extends('layouts.app')

@section('content')
<div class="container-fluid my-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-balance-scale me-2"></i>Balance General</h1>
            <p class="text-muted mb-0">Resumen global de ingresos, gastos y balance por propiedad.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-success shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Total Ingresos</h6>
                    <h3 class="text-success fw-bold">$ {{ number_format($totales['pagos'], 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Total Gastos</h6>
                    <h3 class="text-danger fw-bold">$ {{ number_format($totales['gastos'], 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-{{ $totales['balance'] >= 0 ? 'primary' : 'warning' }} shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Balance Global</h6>
                    <h3 class="fw-bold {{ $totales['balance'] >= 0 ? 'text-primary' : 'text-warning' }}">
                        $ {{ number_format($totales['balance'], 2, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-building me-2"></i>Balance por Propiedad</h5>
        </div>
        <div class="card-body p-0">
            @if($resumen->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Propiedad</th>
                                <th class="text-end">Ingresos</th>
                                <th class="text-end">Gastos</th>
                                <th class="text-end">Balance</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resumen as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('propiedades.show', $item['propiedad']) }}">
                                            {{ $item['propiedad']->nombre }}
                                        </a>
                                    </td>
                                    <td class="text-end text-success">
                                        $ {{ number_format($item['total_pagos'], 2, ',', '.') }}
                                    </td>
                                    <td class="text-end text-danger">
                                        $ {{ number_format($item['total_gastos'], 2, ',', '.') }}
                                    </td>
                                    <td class="text-end fw-bold {{ $item['balance'] >= 0 ? 'text-primary' : 'text-warning' }}">
                                        $ {{ number_format($item['balance'], 2, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('reportes.estado-cuenta', ['propiedad_id' => $item['propiedad']->id]) }}" 
                                           class="btn btn-sm btn-outline-secondary">
                                            Ver estado de cuenta
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-4 text-center text-muted">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p>No hay información suficiente para mostrar el balance general.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
