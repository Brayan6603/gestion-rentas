@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>{{ $categoriaGasto->nombre }}</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('categoria-gastos.edit', $categoriaGasto) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('categoria-gastos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header" style="background-color: {{ $categoriaGasto->color ?? '#6c757d' }}; color: white;">
                    <h5 class="mb-0">Detalles de la Categoría</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted">Nombre</h6>
                        <p class="h5">{{ $categoriaGasto->nombre }}</p>
                    </div>

                    @if($categoriaGasto->descripcion)
                        <div class="mb-3">
                            <h6 class="text-muted">Descripción</h6>
                            <p>{{ $categoriaGasto->descripcion }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <h6 class="text-muted">Color</h6>
                        <div style="width: 60px; height: 40px; background-color: {{ $categoriaGasto->color ?? '#6c757d' }}; border: 2px solid #ddd; border-radius: 4px;"></div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <form action="{{ route('categoria-gastos.destroy', $categoriaGasto) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro? Esto eliminará esta categoría.')">
                        <i class="fas fa-trash"></i> Eliminar Categoría
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info-subtle">
                    <h6 class="mb-0">Información</h6>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-6 text-muted">ID:</dt>
                        <dd class="col-sm-6">{{ $categoriaGasto->id }}</dd>

                        <dt class="col-sm-6 text-muted">Creado:</dt>
                        <dd class="col-sm-6">{{ $categoriaGasto->created_at->format('d/m/Y') }}</dd>

                        <dt class="col-sm-6 text-muted">Actualizado:</dt>
                        <dd class="col-sm-6">{{ $categoriaGasto->updated_at->format('d/m/Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
