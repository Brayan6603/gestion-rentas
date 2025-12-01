@extends('layouts.app')

@section('content')
<div class="container-fluid my-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-file-invoice-dollar me-2"></i>Estado de Cuenta</h1>
            <p class="text-muted mb-0">Detalle de pagos y gastos por propiedad.</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Seleccionar Propiedad</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-6">
                    <label for="propiedad_id" class="form-label">Propiedad</label>
                    <select name="propiedad_id" id="propiedad_id" class="form-select" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach($propiedades as $prop)
                            <option value="{{ $prop->id }}" @selected(optional($propiedad)->id == $prop->id)>
                                {{ $prop->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Ver Estado de Cuenta
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($propiedad)
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-building me-2"></i>{{ $propiedad->nombre }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Dirección:</strong> {{ $propiedad->direccion }}</p>
                        <p class="mb-1"><strong>Renta Mensual:</strong> $ {{ number_format($propiedad->renta_mensual, 2, ',', '.') }}</p>
                        <p class="mb-0"><strong>Estado:</strong>
                            @if($propiedad->estado == 'disponible')
                                <span class="badge bg-success">Disponible</span>
                            @else
                                <span class="badge bg-danger">Rentada</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Pagos</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($pagos->count())
                            <div class="table-responsive">
                                <table class="table table-sm mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Inquilino</th>
                                            <th class="text-end">Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pagos as $pago)
                                            <tr>
                                                <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                                <td>{{ optional($pago->inquilino)->nombre ?? '-' }}</td>
                                                <td class="text-end">$ {{ number_format($pago->monto, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-3 text-center text-muted">
                                No hay pagos registrados.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Gastos</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($gastos->count())
                            <div class="table-responsive">
                                <table class="table table-sm mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Concepto</th>
                                            <th class="text-end">Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($gastos as $gasto)
                                            <tr>
                                                <td>{{ $gasto->fecha_gasto->format('d/m/Y') }}</td>
                                                <td>{{ $gasto->concepto }}</td>
                                                <td class="text-end">$ {{ number_format($gasto->monto, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-3 text-center text-muted">
                                No hay gastos registrados.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
