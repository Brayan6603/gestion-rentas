@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Depósito #{{ $deposito->id }}</h3>
        <div>
            <a href="{{ route('propiedades.depositos.edit', [$propiedad->id, $deposito->id]) }}" class="btn btn-outline-primary">Editar</a>
            <a href="{{ route('propiedades.depositos.index', $propiedad->id) }}" class="btn btn-outline-secondary ms-2">Volver</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body row">
            <div class="col-md-6">
                <p class="mb-1"><strong>Propiedad:</strong> {{ $propiedad->direccion ?? '' }}</p>
                <p class="mb-1"><strong>Inquilino:</strong> {{ optional($deposito->inquilino)->nombre }} {{ optional($deposito->inquilino)->apellido }}</p>
                <p class="mb-1"><strong>Monto:</strong> {{ number_format($deposito->monto,2) }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Fecha Depósito:</strong> {{ optional($deposito->fecha_deposito)->format('Y-m-d') }}</p>
                <p class="mb-1"><strong>Fecha Devolución:</strong> {{ optional($deposito->fecha_devolucion)->format('Y-m-d') ?? '-' }}</p>
                <p class="mb-1"><strong>Estado:</strong>
                    @if($deposito->estado == 'devuelto')
                        <span class="badge bg-success">Devuelto</span>
                    @elseif($deposito->estado == 'parcial')
                        <span class="badge bg-info">Parcial</span>
                    @else
                        <span class="badge bg-warning text-dark">Activo</span>
                    @endif
                </p>
            </div>
        </div>
        @if($deposito->monto_devuelto || $deposito->observaciones || $deposito->concepto_retencion)
        <div class="card-body border-top row">
            @if($deposito->monto_devuelto)
            <div class="col-md-4">
                <p class="mb-1"><strong>Monto Devuelto:</strong> {{ number_format($deposito->monto_devuelto,2) }}</p>
            </div>
            @endif
            @if($deposito->observaciones)
            <div class="col-12">
                <p class="mb-1"><strong>Observaciones:</strong></p>
                <p>{{ $deposito->observaciones }}</p>
            </div>
            @endif
            @if($deposito->concepto_retencion)
            <div class="col-12">
                <p class="mb-1"><strong>Concepto de Retención:</strong></p>
                <p>{{ $deposito->concepto_retencion }}</p>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
