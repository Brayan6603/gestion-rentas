@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Categorías de Gasto</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('categoria-gastos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Categoría
            </a>
        </div>
    </div>

    @if($categorias->count() > 0)
        <div class="row">
            @foreach($categorias as $categoria)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header" style="background-color: {{ $categoria->color ?? '#6c757d' }}; color: white;">
                            <h6 class="mb-0">{{ $categoria->nombre }}</h6>
                        </div>
                        <div class="card-body">
                            @if($categoria->descripcion)
                                <p class="card-text text-muted">{{ Str::limit($categoria->descripcion, 80) }}</p>
                            @else
                                <p class="card-text text-muted"><em>Sin descripción</em></p>
                            @endif
                            
                            <div class="badge bg-light text-dark">
                                {{ $categoria->gastos_count }} 
                                {{ Str::plural('gasto', $categoria->gastos_count) }}
                            </div>
                        </div>
                        <div class="card-footer bg-light d-flex gap-2">
                            <a href="{{ route('categoria-gastos.show', $categoria) }}" class="btn btn-sm btn-info flex-grow-1">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('categoria-gastos.edit', $categoria) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('categoria-gastos.destroy', $categoria) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('¿Está seguro?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $categorias->links() }}
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle"></i>
            No hay categorías de gasto registradas. <a href="{{ route('categoria-gastos.create') }}">Crear una</a>
        </div>
    @endif
</div>
@endsection
