@extends('layouts.app')

@section('content')
<div class="container-fluid my-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1><i class="fas fa-gauge me-2"></i>Dashboard</h1>
            <p class="text-muted">Resumen general de tu sistema de gestión de rentas</p>
        </div>
    </div>

    {{-- Contadores de entidades --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-primary shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-building fa-3x text-primary"></i>
                    </div>
                    <h3 class="fw-bold text-primary mb-0">{{ $propiedadesCount }}</h3>
                    <p class="text-muted mb-2">Propiedades</p>
                    <div class="d-flex justify-content-around small">
                        <span class="badge bg-success">{{ $propiedadesActivas }} Rentadas</span>
                        <span class="badge bg-info">{{ $propiedadesDisponibles }} Disponibles</span>
                    </div>
                </div>
                <div class="card-footer bg-primary bg-opacity-10">
                    <a href="{{ route('propiedades.index') }}" class="text-decoration-none small">
                        Ver todas <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-success shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-users fa-3x text-success"></i>
                    </div>
                    <h3 class="fw-bold text-success mb-0">{{ $inquilinosCount }}</h3>
                    <p class="text-muted mb-2">Inquilinos</p>
                    <div class="small">
                        <span class="badge bg-success">{{ $inquilinosActivos }} Activos</span>
                    </div>
                </div>
                <div class="card-footer bg-success bg-opacity-10">
                    <a href="{{ route('inquilinos.index') }}" class="text-decoration-none small">
                        Ver todos <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-info shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-money-bill-wave fa-3x text-info"></i>
                    </div>
                    <h3 class="fw-bold text-info mb-0">{{ $pagosCount }}</h3>
                    <p class="text-muted mb-2">Pagos Registrados</p>
                    <div class="small text-muted">
                        Total histórico
                    </div>
                </div>
                <div class="card-footer bg-info bg-opacity-10">
                    <a href="{{ route('pagos.index') }}" class="text-decoration-none small">
                        Ver todos <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-warning shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-receipt fa-3x text-warning"></i>
                    </div>
                    <h3 class="fw-bold text-warning mb-0">{{ $gastosCount }}</h3>
                    <p class="text-muted mb-2">Gastos Registrados</p>
                    <div class="small text-muted">
                        Total histórico
                    </div>
                </div>
                <div class="card-footer bg-warning bg-opacity-10">
                    <a href="{{ route('gastos.index') }}" class="text-decoration-none small">
                        Ver todos <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Métricas financieras del mes --}}
    <div class="row g-3 mb-4">
        <div class="col-md-12">
            <h4 class="mb-3"><i class="fas fa-calendar-alt me-2"></i>Resumen del Mes Actual</h4>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-arrow-up me-2"></i>Ingresos</h6>
                    <h3 class="mb-0">₡ {{ number_format($ingresosMes, 2, ',', '.') }}</h3>
                    <small>Pagos recibidos</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white shadow-sm">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-arrow-down me-2"></i>Gastos</h6>
                    <h3 class="mb-0">₡ {{ number_format($gastosMes, 2, ',', '.') }}</h3>
                    <small>Gastos registrados</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-{{ $balanceMes >= 0 ? 'primary' : 'warning' }} text-white shadow-sm">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-balance-scale me-2"></i>Balance</h6>
                    <h3 class="mb-0">₡ {{ number_format($balanceMes, 2, ',', '.') }}</h3>
                    <small>{{ $balanceMes >= 0 ? 'Positivo' : 'Negativo' }}</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-shield-alt me-2"></i>Depósitos Activos</h6>
                    <h3 class="mb-0">₡ {{ number_format($depositosActivos, 2, ',', '.') }}</h3>
                    <small>{{ $depositosCount }} depósitos</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Acciones rápidas --}}
    <div class="row g-3 mb-4">
        <div class="col-md-12">
            <h4 class="mb-3"><i class="fas fa-bolt me-2"></i>Acciones Rápidas</h4>
        </div>
        
        <div class="col-md-3">
            <a href="{{ route('propiedades.create') }}" class="btn btn-primary w-100 py-3 shadow-sm">
                <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                Nueva Propiedad
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('inquilinos.createAll') }}" class="btn btn-success w-100 py-3 shadow-sm">
                <i class="fas fa-user-plus fa-2x d-block mb-2"></i>
                Nuevo Inquilino
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('pagos.index') }}" class="btn btn-info w-100 py-3 shadow-sm">
                <i class="fas fa-money-bill-wave fa-2x d-block mb-2"></i>
                Registrar Pago
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('gastos.index') }}" class="btn btn-warning w-100 py-3 shadow-sm">
                <i class="fas fa-receipt fa-2x d-block mb-2"></i>
                Registrar Gasto
            </a>
        </div>
    </div>

    <div class="row g-3">
        {{-- Últimos pagos --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Últimos Pagos</h5>
                </div>
                <div class="card-body p-0">
                    @if($ultimosPagos->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($ultimosPagos as $pago)
                                <a href="{{ route('propiedades.pagos.show', [$pago->propiedad, $pago]) }}" 
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $pago->inquilino->nombre }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-building me-1"></i>{{ $pago->propiedad->nombre }}
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <strong class="text-success">₡ {{ number_format($pago->monto, 2, ',', '.') }}</strong><br>
                                            <small class="text-muted">{{ $pago->fecha_pago->format('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-inbox fa-3x mb-2"></i>
                            <p>No hay pagos registrados</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-light text-center">
                    <a href="{{ route('pagos.index') }}" class="btn btn-sm btn-outline-primary">
                        Ver todos los pagos
                    </a>
                </div>
            </div>
        </div>

        {{-- Últimos gastos --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Últimos Gastos</h5>
                </div>
                <div class="card-body p-0">
                    @if($ultimosGastos->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($ultimosGastos as $gasto)
                                <a href="{{ route('propiedades.gastos.show', [$gasto->propiedad, $gasto]) }}" 
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $gasto->concepto }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-building me-1"></i>{{ $gasto->propiedad->nombre }}
                                            </small><br>
                                            <span class="badge" style="background-color: {{ $gasto->categoria->color }}">
                                                {{ $gasto->categoria->nombre }}
                                            </span>
                                        </div>
                                        <div class="text-end">
                                            <strong class="text-danger">₡ {{ number_format($gasto->monto, 2, ',', '.') }}</strong><br>
                                            <small class="text-muted">{{ $gasto->fecha_gasto->format('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-inbox fa-3x mb-2"></i>
                            <p>No hay gastos registrados</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-light text-center">
                    <a href="{{ route('gastos.index') }}" class="btn btn-sm btn-outline-warning">
                        Ver todos los gastos
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Gastos por categoría --}}
    @if($gastosPorCategoria->count() > 0)
        <div class="row g-3 mt-3">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Gastos por Categoría (Este Mes)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($gastosPorCategoria as $gastoCategoria)
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3" style="width: 40px; height: 40px; background-color: {{ $gastoCategoria->categoria->color }}; border-radius: 8px;"></div>
                                        <div>
                                            <h6 class="mb-0">{{ $gastoCategoria->categoria->nombre }}</h6>
                                            <strong class="text-danger">₡ {{ number_format($gastoCategoria->total, 2, ',', '.') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection