@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>
                <i class="fas fa-users me-2"></i>Todos los Inquilinos
            </h2>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoInquilino">
                <i class="fas fa-plus-circle me-2"></i>Nuevo Inquilino
            </button>
            <form method="GET" action="{{ route('inquilinos.index') }}" class="d-inline-flex ms-2">
                <div class="input-group" style="width: auto;">
                    <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por nombre, email...">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
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
                                                  action="{{ route('inquilinos.destroyAll', $inquilino->id) }}" 
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
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoInquilino">
                <i class="fas fa-plus-circle"></i> Crear Primer Inquilino
            </button>
        </div>
    @endif
</div>

<!-- Modal para crear nuevo inquilino -->
<div class="modal fade" id="modalNuevoInquilino" tabindex="-1" aria-labelledby="modalNuevoInquilinoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalNuevoInquilinoLabel">
                    <i class="fas fa-user-plus me-2"></i>Nuevo Inquilino
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('inquilinos.storeAll') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="propiedad_id" class="form-label">Departamento *</label>
                        <select class="form-select @error('propiedad_id') is-invalid @enderror" 
                                id="propiedad_id" name="propiedad_id" required>
                            <option value="">Selecciona un departamento...</option>
                            @forelse ($propiedades as $propiedad)
                                <option value="{{ $propiedad->id }}" {{ old('propiedad_id') == $propiedad->id ? 'selected' : '' }}>
                                    {{ $propiedad->nombre }} - {{ $propiedad->direccion }}
                                </option>
                            @empty
                                <option value="" disabled>No hay departamentos disponibles</option>
                            @endforelse
                        </select>
                        @error('propiedad_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control @error('telefono') is-invalid @enderror" 
                               id="telefono" name="telefono" value="{{ old('telefono') }}">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha de Inicio *</label>
                                <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                       id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
                                @error('fecha_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                                <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror" 
                                       id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}">
                                @error('fecha_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle me-2"></i>Guardar Inquilino
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection
