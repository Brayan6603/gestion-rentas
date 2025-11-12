@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>
                <i class="fas fa-users me-2"></i>Todos los Inquilinos
            </h2>
        </div>
        <div class="col-md-4 text-end">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Buscar por nombre, email...">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($inquilinos->count())
        <div class="row">
            @foreach ($inquilinos as $inquilino)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow" style="transition: transform 0.2s, box-shadow 0.2s;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title mb-1">{{ $inquilino->nombre }}</h5>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-building me-1"></i>
                                        {{ $inquilino->propiedad->nombre }}
                                    </p>
                                </div>
                                <span class="badge bg-primary">
                                    @if ($inquilino->fecha_fin)
                                        {{ $inquilino->fecha_fin->format('d/m/Y') }}
                                    @else
                                        <i class="fas fa-check-circle"></i> Vigente
                                    @endif
                                </span>
                            </div>

                            <hr class="my-2">

                            <div class="small mb-3">
                                <p class="mb-2">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <a href="mailto:{{ $inquilino->email }}">{{ $inquilino->email }}</a>
                                </p>
                                @if ($inquilino->telefono)
                                    <p class="mb-2">
                                        <i class="fas fa-phone text-success me-2"></i>
                                        <a href="tel:{{ $inquilino->telefono }}">{{ $inquilino->telefono }}</a>
                                    </p>
                                @endif
                                <p class="mb-0">
                                    <i class="fas fa-calendar text-warning me-2"></i>
                                    Desde: {{ $inquilino->fecha_inicio->format('d/m/Y') }}
                                </p>
                            </div>

                            <hr class="my-2">

                            <div class="d-flex gap-2 justify-content-between">
                                <a href="{{ route('propiedades.inquilinos.show', [$inquilino->propiedad_id, $inquilino->id]) }}" 
                                   class="btn btn-sm btn-info" title="Ver detalle">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('propiedades.inquilinos.edit', [$inquilino->propiedad_id, $inquilino->id]) }}" 
                                   class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-pencil-alt"></i> Editar
                                </a>
                                <form method="POST" 
                                      action="{{ route('propiedades.inquilinos.destroy', [$inquilino->propiedad_id, $inquilino->id]) }}" 
                                      class="d-inline" 
                                      onsubmit="return confirm('¿Estás seguro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $inquilinos->links() }}
        </div>
    @else
        <div class="alert alert-info text-center py-5">
            <h4><i class="fas fa-inbox"></i> Sin inquilinos</h4>
            <p>No tienes inquilinos registrados aún.</p>
            <a href="{{ route('propiedades.index') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Ir a Departamentos
            </a>
        </div>
    @endif
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection
