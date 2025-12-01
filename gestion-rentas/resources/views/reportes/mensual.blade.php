@extends('layouts.app')

@section('content')
<div class="container-fluid my-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-calendar-alt me-2"></i>Reporte Mensual</h1>
            <p class="text-muted mb-0">Resumen de ingresos y gastos del mes seleccionado.</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" for="month">Mes</label>
                    <select name="month" id="month" class="form-select">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" @selected($m == $month)>{{ $m }}</option>
                        @endfor
                    </select>
                </div>
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
                    <h6 class="text-muted">Ingresos</h6>
                    <h3 class="text-success fw-bold">$ {{ number_format($pagos, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Gastos</h6>
                    <h3 class="text-danger fw-bold">$ {{ number_format($gastos, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-{{ $balance >= 0 ? 'primary' : 'warning' }} shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Balance</h6>
                    <h3 class="fw-bold {{ $balance >= 0 ? 'text-primary' : 'text-warning' }}">
                        $ {{ number_format($balance, 2, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Detalle de Pagos</h5>
                </div>
                <div class="card-body p-0">
                    @if($detallesPagos->count())
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Propiedad</th>
                                        <th class="text-end">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detallesPagos as $pago)
                                        <tr>
                                            <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                            <td>{{ $pago->propiedad->nombre }}</td>
                                            <td class="text-end">$ {{ number_format($pago->monto, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-3 text-center text-muted">No hay pagos registrados para este mes.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Detalle de Gastos</h5>
                </div>
                <div class="card-body p-0">
                    @if($detallesGastos->count())
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Propiedad</th>
                                        <th>Concepto</th>
                                        <th class="text-end">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detallesGastos as $gasto)
                                        <tr>
                                            <td>{{ $gasto->fecha_gasto->format('d/m/Y') }}</td>
                                            <td>{{ $gasto->propiedad->nombre }}</td>
                                            <td>{{ $gasto->concepto }}</td>
                                            <td class="text-end">$ {{ number_format($gasto->monto, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-3 text-center text-muted">No hay gastos registrados para este mes.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
