@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Registrar depósito - {{ $propiedad->direccion ?? '' }}</h3>

    <form action="{{ route('propiedades.depositos.store', $propiedad->id) }}" method="POST">
        @include('depositos._form')
    </form>
</div>
@endsection
