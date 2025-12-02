@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0">Todos los Depósitos</h3>
            <div class="text-muted small">Total mostrado: <strong>{{ number_format($total,2) }}</strong></div>
        </div>
        <div>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">Volver</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('depositos.index') }}" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small">Propiedad</label>
                        <select name="propiedad_id" class="form-select">
                            <option value="">Todas</option>
                            @foreach($propiedades as $prop)
                                <option value="{{ $prop->id }}" {{ request('propiedad_id') == $prop->id ? 'selected' : '' }}>{{ $prop->direccion ?? $prop->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Inquilino</label>
                        <select name="inquilino_id" class="form-select">
                            <option value="">Todos</option>
                            @foreach($inquilinos as $inq)
                                <option value="{{ $inq->id }}" {{ request('inquilino_id') == $inq->id ? 'selected' : '' }}>{{ $inq->nombre }} {{ $inq->apellido ?? '' }} ({{ $inq->propiedad->nombre ?? '' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="">Todos</option>
                            <option value="activo" {{ request('estado')=='activo' ? 'selected':'' }}>Activo</option>
                            <option value="parcialmente_devuelto" {{ request('estado')=='parcialmente_devuelto' ? 'selected':'' }}>Parcialmente Devuelto</option>
                            <option value="retenido" {{ request('estado')=='retenido' ? 'selected':'' }}>Retenido</option>
                            <option value="devuelto" {{ request('estado')=='devuelto' ? 'selected':'' }}>Devuelto</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label small">&nbsp;</label>
                        <button class="btn btn-primary w-100">Filtrar</button>
                    </div>
            </form>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('depositos.index') }}" class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label small">Fecha desde</label>
                            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Fecha hasta</label>
                            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="form-control">
                        </div>
                        <div class="col-md-6 text-center">
                            <a href="{{ route('depositos.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
    </div>

    <div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Propiedad</th>
                <th>Inquilino</th>
                <th class="text-end">Monto</th>
                <th>Fecha Depósito</th>
                <th>Fecha Devolución</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($depositos as $deposito)
                <tr>
                    <td>{{ $deposito->id }}</td>
                    <td>
                        @if($deposito->propiedad)
                            <a href="{{ route('propiedades.depositos.index', $deposito->propiedad->id) }}">{{ $deposito->propiedad->direccion ?? 'Propiedad #' . $deposito->propiedad->id }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $deposito->inquilino ? $deposito->inquilino->nombre . ' ' . ($deposito->inquilino->apellido ?? '') : '-' }}</td>
                    <td class="text-end">{{ number_format($deposito->monto, 2) }}</td>
                    <td>{{ optional($deposito->fecha_deposito)->format('Y-m-d') }}</td>
                    <td>{{ optional($deposito->fecha_devolucion)->format('Y-m-d') ?? '-' }}</td>
                    <td>
                        @if($deposito->estado == 'devuelto')
                            <span class="badge bg-success">Devuelto</span>
                        @elseif($deposito->estado == 'parcialmente_devuelto')
                            <span class="badge bg-info">Parcialmente Devuelto</span>
                        @elseif($deposito->estado == 'retenido')
                            <span class="badge bg-danger">Retenido</span>
                        @else
                            <span class="badge bg-warning text-dark">Activo</span>
                        @endif
                    </td>
                    <td class="text-end">
                        @if($deposito->propiedad)
                            <a href="{{ route('propiedades.depositos.show', [$deposito->propiedad->id, $deposito->id]) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                            <a href="{{ route('propiedades.depositos.edit', [$deposito->propiedad->id, $deposito->id]) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                        @else
                            <a href="#" class="btn btn-sm btn-secondary">Ver</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay depósitos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    {{ $depositos->links() }}
</div>
@endsection
