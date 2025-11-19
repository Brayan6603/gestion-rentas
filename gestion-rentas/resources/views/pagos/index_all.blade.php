@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Todos los Pagos</h3>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Propiedad</th>
                <th>Mes</th>
                <th>Inquilino</th>
                <th>Monto</th>
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
                    <td>{{ $pago->inquilino ? $pago->inquilino->nombre : '-' }}</td>
                    <td>{{ number_format($pago->monto, 2) }}</td>
                    <td>{{ optional($pago->fecha_pago)->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($pago->estado) }}</td>
                    <td class="text-end">
                        @if($pago->propiedad)
                            <a href="{{ route('propiedades.pagos.show', [$pago->propiedad->id, $pago->id]) }}" class="btn btn-sm btn-primary">Ver</a>
                            <a href="{{ route('propiedades.pagos.edit', [$pago->propiedad->id, $pago->id]) }}" class="btn btn-sm btn-secondary">Editar</a>
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

    {{ $pagos->links() }}
</div>
@endsection
