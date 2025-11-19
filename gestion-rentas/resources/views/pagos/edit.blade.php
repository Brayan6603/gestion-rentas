@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Editar pago #{{ $pago->id }} - {{ $propiedad->direccion ?? '' }}</h3>

    <form action="{{ route('propiedades.pagos.update', [$propiedad->id, $pago->id]) }}" method="POST">
        @method('PUT')
        @include('pagos._form')
    </form>
</div>
@endsection
