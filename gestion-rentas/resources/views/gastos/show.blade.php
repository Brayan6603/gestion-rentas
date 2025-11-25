@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Detalle del Gasto</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('propiedades.gastos.edit', [$propiedad, $gasto]) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('propiedades.gastos.index', $propiedad) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary-subtle">
                    <h5 class="mb-0">{{ $gasto->concepto }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Concepto</h6>
                            <p class="h5">{{ $gasto->concepto }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Monto</h6>
                            <p class="h5">₡ {{ number_format($gasto->monto, 2, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Fecha del Gasto</h6>
                            <p>{{ $gasto->fecha_gasto->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Categoría</h6>
                            <p>
                                <span class="badge" style="background-color: {{ $gasto->categoria->color ?? '#6c757d' }}">
                                    {{ $gasto->categoria->nombre }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Propiedad</h6>
                            <p>
                                <a href="{{ route('propiedades.show', $propiedad) }}">
                                    {{ $propiedad->nombre }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Registrado</h6>
                            <p>{{ $gasto->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    @if($gasto->descripcion)
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-muted">Descripción</h6>
                                <p>{{ $gasto->descripcion }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-3">
                <form action="{{ route('propiedades.gastos.destroy', [$propiedad, $gasto]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar este gasto?')">
                        <i class="fas fa-trash"></i> Eliminar Gasto
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
                        <dd class="col-sm-6">{{ $gasto->id }}</dd>

                        <dt class="col-sm-6 text-muted">Creado:</dt>
                        <dd class="col-sm-6">{{ $gasto->created_at->format('d/m/Y') }}</dd>

                        <dt class="col-sm-6 text-muted">Actualizado:</dt>
                        <dd class="col-sm-6">{{ $gasto->updated_at->format('d/m/Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
