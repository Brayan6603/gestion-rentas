@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>{{ $inquilino->nombre }}</h2>
            <p class="text-muted">Propiedad: {{ $propiedad->nombre }}</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('propiedades.inquilinos.edit', [$propiedad->id, $inquilino->id]) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Información Personal -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person"></i> Información Personal</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label class="form-label"><strong>Email:</strong></label>
                        </div>
                        <div class="col-sm-8">
                            <p>{{ $inquilino->email }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label class="form-label"><strong>Teléfono:</strong></label>
                        </div>
                        <div class="col-sm-8">
                            <p>{{ $inquilino->telefono ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fechas de Contrato -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar"></i> Contrato</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label class="form-label"><strong>Inicio:</strong></label>
                        </div>
                        <div class="col-sm-8">
                            <p>{{ $inquilino->fecha_inicio->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label class="form-label"><strong>Fin:</strong></label>
                        </div>
                        <div class="col-sm-8">
                            @if ($inquilino->fecha_fin)
                                <p>{{ $inquilino->fecha_fin->format('d/m/Y') }}</p>
                            @else
                                <span class="badge bg-success">Vigente (sin fecha de fin)</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagos -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-cash-coin"></i> Pagos</h5>
                </div>
                <div class="card-body">
                    @if ($pagos->count())
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Monto</th>
                                        <th>Mes Correspondiente</th>
                                        <th>Fecha de Pago</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pagos as $pago)
                                        <tr>
                                            <td><strong>${{ number_format($pago->monto, 2) }}</strong></td>
                                            <td>{{ $pago->mes_correspondiente->format('m/Y') }}</td>
                                            <td>{{ $pago->fecha_pago?->format('d/m/Y') ?? '-' }}</td>
                                            <td>
                                                @if ($pago->estado === 'pagado')
                                                    <span class="badge bg-success">Pagado</span>
                                                @elseif ($pago->estado === 'vencido')
                                                    <span class="badge bg-danger">Vencido</span>
                                                @else
                                                    <span class="badge bg-warning">Pendiente</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $pagos->links() }}
                        </div>
                    @else
                        <p class="text-muted">No hay pagos registrados.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Depósitos -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-piggy-bank"></i> Depósitos</h5>
                </div>
                <div class="card-body">
                    @if ($depositos->count())
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Monto</th>
                                        <th>Fecha Depósito</th>
                                        <th>Estado</th>
                                        <th>Monto Devuelto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($depositos as $deposito)
                                        <tr>
                                            <td><strong>${{ number_format($deposito->monto, 2) }}</strong></td>
                                            <td>{{ $deposito->fecha_deposito->format('d/m/Y') }}</td>
                                            <td>
                                                @if ($deposito->estado === 'activo')
                                                    <span class="badge bg-info">Activo</span>
                                                @elseif ($deposito->estado === 'devuelto')
                                                    <span class="badge bg-success">Devuelto</span>
                                                @elseif ($deposito->estado === 'retenido')
                                                    <span class="badge bg-danger">Retenido</span>
                                                @else
                                                    <span class="badge bg-warning">Parcialmente Devuelto</span>
                                                @endif
                                            </td>
                                            <td>${{ number_format($deposito->monto_devuelto ?? 0, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $depositos->links() }}
                        </div>
                    @else
                        <p class="text-muted">No hay depósitos registrados.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
