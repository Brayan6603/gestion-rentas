@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0">Depósitos - {{ $propiedad->direccion ?? 'Propiedad' }}</h3>
            <div class="text-muted small">Total depósitos activos: <strong>{{ number_format($depositos->where('estado', '!=', 'devuelto')->sum('monto'),2) }}</strong></div>
        </div>
        @php
            $inquilinoActual = $propiedad->inquilinoActual();
            $urlDeposito = route('propiedades.depositos.create', $propiedad->id);
            if ($inquilinoActual) {
                $urlDeposito .= '?inquilino_id=' . $inquilinoActual->id . '&monto=' . $propiedad->deposito_sugerido;
            }
        @endphp
        <div>
            <a href="{{ $urlDeposito }}" class="btn btn-success">Registrar depósito</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
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
                        <a href="{{ route('propiedades.depositos.show', [$propiedad->id, $deposito->id]) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                        <a href="{{ route('propiedades.depositos.edit', [$propiedad->id, $deposito->id]) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                        <form action="{{ route('propiedades.depositos.destroy', [$propiedad->id, $deposito->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Eliminar depósito?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No hay depósitos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    {{ $depositos->links() }}
</div>
@endsection
