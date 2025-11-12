@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Inquilinos de {{ $propiedad->nombre }}</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('propiedades.inquilinos.create', $propiedad->id) }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Inquilino
            </a>
            <a href="{{ route('propiedades.show', $propiedad->id) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($inquilinos->count())
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inquilinos as $inquilino)
                            <tr>
                                <td>
                                    <strong>{{ $inquilino->nombre }}</strong>
                                </td>
                                <td>{{ $inquilino->email }}</td>
                                <td>{{ $inquilino->telefono ?? '-' }}</td>
                                <td>{{ $inquilino->fecha_inicio->format('d/m/Y') }}</td>
                                <td>
                                    @if ($inquilino->fecha_fin)
                                        {{ $inquilino->fecha_fin->format('d/m/Y') }}
                                    @else
                                        <span class="badge bg-success">Vigente</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('propiedades.inquilinos.show', [$propiedad->id, $inquilino->id]) }}" 
                                       class="btn btn-sm btn-info" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('propiedades.inquilinos.edit', [$propiedad->id, $inquilino->id]) }}" 
                                       class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" 
                                          action="{{ route('propiedades.inquilinos.destroy', [$propiedad->id, $inquilino->id]) }}" 
                                          class="d-inline" 
                                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar este inquilino?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $inquilinos->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">
            <p>No hay inquilinos registrados para esta propiedad.</p>
            <a href="{{ route('propiedades.inquilinos.create', $propiedad->id) }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Crear Primer Inquilino
            </a>
        </div>
    @endif
</div>
@endsection
