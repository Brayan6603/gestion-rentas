@extends('layouts.app')

@section('title', $propiedad->nombre)

@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-building me-2"></i>{{ $propiedad->nombre }}
        </h1>
        <div>
            <a href="{{ route('propiedades.edit', $propiedad) }}" class="btn btn-warning shadow-sm">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <a href="{{ route('propiedades.index') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Información Principal -->
        <div class="col-lg-8">
            <!-- Tarjeta de Información General -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Información General
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th class="text-muted">Nombre:</th>
                                    <td>{{ $propiedad->nombre }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Tipo:</th>
                                    <td>
                                        @switch($propiedad->tipo)
                                            @case('departamento')
                                                <span class="badge bg-info">
                                                    <i class="fas fa-building me-1"></i>Departamento
                                                </span>
                                                @break
                                            @case('casa')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-home me-1"></i>Casa
                                                </span>
                                                @break
                                            @case('local')
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-store me-1"></i>Local
                                                </span>
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Estado:</th>
                                    <td>
                                        @if($propiedad->estado == 'disponible')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Disponible
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>Rentada
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th class="text-muted">Renta Mensual:</th>
                                    <td class="h5 text-success">${{ number_format($propiedad->renta_mensual, 2) }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Depósito Sugerido:</th>
                                    <td class="text-info">${{ number_format($propiedad->deposito_sugerido, 2) }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Fecha Registro:</th>
                                    <td>{{ $propiedad->created_at->format('d/m/Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="mb-3">
                        <strong class="text-muted">Dirección:</strong>
                        <p class="mb-0">{{ $propiedad->direccion }}</p>
                    </div>

                    <!-- Descripción -->
                    @if($propiedad->descripcion)
                    <div class="mt-3">
                        <strong class="text-muted">Descripción:</strong>
                        <p class="mb-0">{{ $propiedad->descripcion }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Tarjeta de Dirección -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-map-marker-alt me-2"></i>Ubicación
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Dirección completa:</strong></p>
                    <p class="text-muted">{{ $propiedad->direccion }}</p>
                    <div class="mt-3 p-3 bg-light rounded">
                        {!! $propiedad->mapa_embed_code !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar con Estadísticas -->
        <div class="col-lg-4">
            <!-- Tarjeta de Acciones Rápidas -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-gamepad me-2"></i>Acciones
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('propiedades.edit', $propiedad) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Editar Propiedad
                        </a>
                        <a href="{{ route('propiedades.inquilinos.index', $propiedad->id) }}" class="btn btn-success">
                            <i class="fas fa-users me-2"></i>Gestionar Inquilinos
                        </a>
                        
                        <a href="{{ route('propiedades.pagos.index', $propiedad->id) }}" class="btn btn-info">
                            <i class="fas fa-money-bill-wave me-2"></i>Gestionar Pagos
                        </a>
                       
                        <a href="{{ route('propiedades.gastos.index', $propiedad->id) }}" class="btn btn-secondary">
                            <i class="fas fa-receipt me-2"></i>Gestionar Gastos
                        </a>
                        
                        <a href="{{ route('propiedades.depositos.index', $propiedad->id) }}" class="btn btn-warning">
                            <i class="fas fa-shield-alt me-2"></i>Gestionar Depósitos
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Estadísticas -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-bar me-2"></i>Estadísticas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-check fa-2x text-info mb-2"></i>
                            @php
                                $inquilinoActual = $propiedad->inquilinoActual();
                            @endphp

                            @if($inquilinoActual)
                                <h6 class="mb-1">{{ $inquilinoActual->nombre }}</h6>
                                @if($inquilinoActual->fecha_inicio)
                                    <small class="text-muted">
                                        Desde {{ $inquilinoActual->fecha_inicio->format('d/m/Y') }}
                                    </small>
                                @endif
                            @else
                                <h6 class="mb-1">Sin inquilino actual</h6>
                                <small class="text-muted">La propiedad está disponible</small>
                            @endif
                        </div>

                        <div class="mb-3">
                            <i class="fas fa-users fa-2x text-primary mb-2"></i>
                            <h5>{{ $propiedad->inquilinos->count() }}</h5>
                            <small class="text-muted">Número de inquilinos Registrados (Histórico)</small>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-money-bill-wave fa-2x text-success mb-2"></i>
                            <h5>${{ number_format($propiedad->balanceMensual(), 2) }}</h5>
                            <small class="text-muted">Balance del Mes</small>
                        </div>
                        <div>
                            <i class="fas fa-shield-alt fa-2x text-warning mb-2"></i>
                            <h5>${{ number_format($propiedad->totalDepositosActivos(), 2) }}</h5>
                            <small class="text-muted">Depósitos Activos</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection