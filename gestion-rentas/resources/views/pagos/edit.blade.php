@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row mb-4">
        <div class="col">
            <h1>Editar pago #{{ $pago->id }} - {{ $propiedad->direccion ?? '' }}</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary-subtle">
            <h5 class="mb-0">Editar Pago</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('propiedades.pagos.update', [$propiedad->id, $pago->id]) }}" method="POST" class="needs-validation" novalidate>
                @method('PUT')
                @include('pagos._form')
            </form>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('propiedades.pagos.show', [$propiedad, $pago]) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>
@endsection
