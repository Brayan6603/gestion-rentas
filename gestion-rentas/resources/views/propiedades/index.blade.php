@extends('layouts.app')

@section('title', 'Gestión de Propiedades')

@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-building me-2"></i>Gestión de Propiedades
        </h1>
        <a href="{{ route('propiedades.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i>Nueva Propiedad
        </a>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tarjeta de Propiedades -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Lista de Propiedades
            </h6>
        </div>
        <div class="card-body">
            @if($propiedades->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Renta Mensual</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($propiedades as $propiedad)
                            <tr>
                                <td>
                                    <strong>{{ $propiedad->nombre }}</strong>
                                    @if($propiedad->descripcion)
                                        <br><small class="text-muted">{{ Str::limit($propiedad->descripcion, 50) }}</small>
                                    @endif
                                </td>
                                <td>{{ Str::limit($propiedad->direccion, 60) }}</td>
                                <td>
                                    <span class="fw-bold text-success">${{ number_format($propiedad->renta_mensual, 2) }}</span>
                                </td>
                                <td>
                                    @switch($propiedad->tipo)
                                        @case('departamento')
                                            <span class="badge bg-info">
                                                <i class="fas fa-building me-1"></i>Departamento
                                            </span>
                                            @break
                                        @case('casa')
                                            <span class="badge bg-success">
                                                <i class="fas fa-home me-1"></i>Casa
                                            </span>
                                            @break
                                        @case('local')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-store me-1"></i>Local
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @if($propiedad->estado == 'disponible')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Disponible
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle me-1"></i>Rentada
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('propiedades.show', $propiedad) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('propiedades.edit', $propiedad) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('propiedades.destroy', $propiedad) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta propiedad?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Mostrando {{ $propiedades->firstItem() }} - {{ $propiedades->lastItem() }} de {{ $propiedades->total() }} propiedades
                    </div>
                    {{ $propiedades->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-building fa-4x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-400">No hay propiedades registradas</h5>
                    <p class="text-muted">Comienza agregando tu primera propiedad.</p>
                    <a href="{{ route('propiedades.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Agregar Primera Propiedad
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table td {
        vertical-align: middle;
    }
    .btn-group .btn {
        border-radius: 0.375rem;
        margin: 0 2px;
    }
</style>
@endpush