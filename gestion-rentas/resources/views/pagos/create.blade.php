@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Registrar pago - {{ $propiedad->direccion ?? '' }}</h3>

    <form action="{{ route('propiedades.pagos.store', $propiedad->id) }}" method="POST">
        @include('pagos._form')
    </form>
</div>
@endsection
