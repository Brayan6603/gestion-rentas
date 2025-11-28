@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0">Pagos - {{ $propiedad->direccion ?? 'Propiedad' }}</h3>
            <div class="text-muted small">Total pagos mostrados: <strong>{{ number_format($pagos->sum('monto'),2) }}</strong></div>
        </div>
        @php
            $inquilinoActual = $propiedad->inquilinoActual();
            $urlPago = route('propiedades.pagos.create', $propiedad->id);
            if ($inquilinoActual) {
                $urlPago .= '?inquilino_id=' . $inquilinoActual->id . '&monto=' . $propiedad->renta_mensual;
            }
        @endphp
        <div>
            <a href="{{ $urlPago }}" class="btn btn-success">Registrar pago</a>
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
                    <td>{{ optional($pago->mes_correspondiente)->format('Y-m') }}</td>
                    <td>{{ $pago->inquilino ? $pago->inquilino->nombre . ' ' . ($pago->inquilino->apellido ?? '') : '-' }}</td>
                    <td class="text-end">{{ number_format($pago->monto, 2) }}</td>
                    <td>{{ optional($pago->fecha_pago)->format('Y-m-d') }}</td>
                    <td>
                        @if($pago->estado == 'pagado')
                            <span class="badge bg-success">Pagado</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('propiedades.pagos.show', [$propiedad->id, $pago->id]) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                        <a href="{{ route('propiedades.pagos.edit', [$propiedad->id, $pago->id]) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                        <form action="{{ route('propiedades.pagos.destroy', [$propiedad->id, $pago->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Eliminar pago?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No hay pagos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    {{ $pagos->links() }}
</div>
@endsection
