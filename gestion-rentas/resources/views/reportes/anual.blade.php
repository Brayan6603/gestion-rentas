@extends('layouts.app')

@section('content')
<div class="container-fluid my-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-chart-line me-2"></i>Reporte Anual</h1>
            <p class="text-muted mb-0">Resumen de ingresos, gastos y balance por mes.</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" for="year">Año</label>
                    <input type="number" name="year" id="year" class="form-control" value="{{ $year }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-success shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Ingresos del Año</h6>
                    <h3 class="text-success fw-bold">$ {{ number_format($totales['ingresos'], 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Gastos del Año</h6>
                    <h3 class="text-danger fw-bold">$ {{ number_format($totales['gastos'], 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-{{ $totales['balance'] >= 0 ? 'primary' : 'warning' }} shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Balance del Año</h6>
                    <h3 class="fw-bold {{ $totales['balance'] >= 0 ? 'text-primary' : 'text-warning' }}">
                        $ {{ number_format($totales['balance'], 2, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-table me-2"></i>Detalle por Mes</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mes</th>
                            <th class="text-end">Ingresos</th>
                            <th class="text-end">Gastos</th>
                            <th class="text-end">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meses as $item)
                            <tr>
                                <td>{{ str_pad($item['mes'], 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="text-end text-success">$ {{ number_format($item['ingresos'], 2, ',', '.') }}</td>
                                <td class="text-end text-danger">$ {{ number_format($item['gastos'], 2, ',', '.') }}</td>
                                <td class="text-end fw-bold {{ $item['balance'] >= 0 ? 'text-primary' : 'text-warning' }}">
                                    $ {{ number_format($item['balance'], 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
