@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Pagos - {{ $propiedad->direccion ?? 'Propiedad' }}</h3>
        <a href="{{ route('propiedades.pagos.create', $propiedad->id) }}" class="btn btn-success">Registrar pago</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
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
                    <td>{{ optional($pago->mes_correspondiente)->format('Y-m') }}</td>
                    <td>{{ $pago->inquilino ? $pago->inquilino->nombre : '-' }}</td>
                    <td>{{ number_format($pago->monto, 2) }}</td>
                    <td>{{ optional($pago->fecha_pago)->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($pago->estado) }}</td>
                    <td class="text-end">
                        <a href="{{ route('propiedades.pagos.show', [$propiedad->id, $pago->id]) }}" class="btn btn-sm btn-primary">Ver</a>
                        <a href="{{ route('propiedades.pagos.edit', [$propiedad->id, $pago->id]) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <form action="{{ route('propiedades.pagos.destroy', [$propiedad->id, $pago->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Eliminar pago?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Borrar</button>
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

    {{ $pagos->links() }}
</div>
@endsection
