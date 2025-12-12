@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Pago #{{ $pago->id }}</h3>
        <div>
            <a href="{{ route('propiedades.pagos.edit', [$propiedad->id, $pago->id]) }}" class="btn btn-outline-primary">Editar</a>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary ms-2">Volver</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body row">
            <div class="col-md-6">
                <p class="mb-1"><strong>Propiedad:</strong> {{ $propiedad->direccion ?? '' }}</p>
                <p class="mb-1"><strong>Inquilino:</strong> {{ optional($pago->inquilino)->nombre }} {{ optional($pago->inquilino)->apellido }}</p>
                <p class="mb-1"><strong>Mes correspondiente:</strong> {{ optional($pago->mes_correspondiente)->format('Y-m') }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Monto:</strong> {{ number_format($pago->monto,2) }}</p>
                <p class="mb-1"><strong>Fecha pago:</strong> {{ optional($pago->fecha_pago)->format('Y-m-d') }}</p>
                <p class="mb-1"><strong>Estado:</strong>
                    @if($pago->estado == 'pagado')
                        <span class="badge bg-success">Pagado</span>
                    @elseif($pago->estado == 'parcial')
                        <span class="badge bg-info text-dark">Parcial</span>
                    @elseif($pago->estado == 'vencido')
                        <span class="badge bg-danger">Vencido</span>
                    @else
                        <span class="badge bg-warning text-dark">Pendiente</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
