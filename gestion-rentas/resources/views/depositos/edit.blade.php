@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Editar depósito #{{ $deposito->id }} - {{ $propiedad->direccion ?? '' }}</h3>

    <form action="{{ route('propiedades.depositos.update', [$propiedad->id, $deposito->id]) }}" method="POST">
        @method('PUT')
        @include('depositos._form')
    </form>
</div>
@endsection
