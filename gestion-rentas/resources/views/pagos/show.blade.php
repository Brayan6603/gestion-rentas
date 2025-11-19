@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Pago #{{ $pago->id }}</h3>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Propiedad:</strong> {{ $propiedad->direccion ?? '' }}</p>
            <p><strong>Inquilino:</strong> {{ optional($pago->inquilino)->nombre }}</p>
            <p><strong>Mes correspondiente:</strong> {{ optional($pago->mes_correspondiente)->format('Y-m') }}</p>
            <p><strong>Monto:</strong> {{ number_format($pago->monto,2) }}</p>
            <p><strong>Fecha pago:</strong> {{ optional($pago->fecha_pago)->format('Y-m-d') }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($pago->estado) }}</p>
        </div>
    </div>

    <a href="{{ route('propiedades.pagos.index', $propiedad->id) }}" class="btn btn-secondary">Volver</a>
    <a href="{{ route('propiedades.pagos.edit', [$propiedad->id, $pago->id]) }}" class="btn btn-primary">Editar</a>
</div>
@endsection
