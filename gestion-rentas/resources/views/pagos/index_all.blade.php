@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0">Todos los Pagos</h3>
            <div class="text-muted small">Total mostrado: <strong>{{ number_format($total,2) }}</strong></div>
        </div>
        <div>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">Volver</a>
            <a href="{{ route('propiedades.index') }}" class="btn btn-primary">Ver Propiedades</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('pagos.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small">Propiedad</label>
                    <select name="propiedad_id" class="form-select">
                        <option value="">Todas</option>
                        @foreach($propiedades as $prop)
                            <option value="{{ $prop->id }}" {{ request('propiedad_id') == $prop->id ? 'selected' : '' }}>{{ $prop->direccion ?? $prop->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="pendiente" {{ request('estado')=='pendiente' ? 'selected':'' }}>Pendiente</option>
                        <option value="pagado" {{ request('estado')=='pagado' ? 'selected':'' }}>Pagado</option>
                        <option value="parcial" {{ request('estado')=='parcial' ? 'selected':'' }}>Pagado parcialmente</option>
                        <option value="vencido" {{ request('estado')=='vencido' ? 'selected':'' }}>Vencido</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Buscar Inquilino</label>
                    <input type="search" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Nombre o apellido">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Propiedad</th>
                <th>Mes</th>
                <th>Inquilino</th>
                <th class="text-end">Monto</th>
                <th>Fecha pago</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($pagos as $pago)
                <tr>
                    <td>{{ $pago->id }}</td>
                    <td>
                        @if($pago->propiedad)
                            <a href="{{ route('propiedades.pagos.index', $pago->propiedad->id) }}">{{ $pago->propiedad->direccion ?? 'Propiedad #' . $pago->propiedad->id }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ optional($pago->mes_correspondiente)->format('Y-m') }}</td>
                    <td>{{ $pago->inquilino ? $pago->inquilino->nombre . ' ' . ($pago->inquilino->apellido ?? '') : '-' }}</td>
                    <td class="text-end">{{ number_format($pago->monto, 2) }}</td>
                    <td>{{ optional($pago->fecha_pago)->format('Y-m-d') }}</td>
                    <td>
                        @if($pago->estado == 'pagado')
                            <span class="badge bg-success">Pagado</span>
                        @elseif($pago->estado == 'parcial')
                            <span class="badge bg-info text-dark">Parcial</span>
                        @elseif($pago->estado == 'vencido')
                            <span class="badge bg-danger">Vencido</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
                    </td>
                    <td class="text-end">
                        @if($pago->propiedad)
                            <a href="{{ route('propiedades.pagos.show', [$pago->propiedad->id, $pago->id]) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                            <a href="{{ route('propiedades.pagos.edit', [$pago->propiedad->id, $pago->id]) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                        @else
                            <a href="#" class="btn btn-sm btn-secondary">Ver</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay pagos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    {{ $pagos->links() }}
</div>
@endsection
