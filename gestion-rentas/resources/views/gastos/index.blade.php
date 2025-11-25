@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Gastos - {{ $propiedad->nombre }}</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('propiedades.gastos.create', $propiedad, ['categoria_gasto_id' => request('categoria_gasto_id'), 'monto' => request('monto')]) }}" 
               class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Gasto
            </a>
            <a href="{{ route('propiedades.show', $propiedad) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0">Filtros</h6>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="categoria_filter" class="form-label">Categoría</label>
                    <select id="categoria_filter" name="categoria" class="form-select form-select-sm">
                        <option value="">-- Todas --</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" @selected(request('categoria') == $cat->id)>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="fecha_desde" class="form-label">Desde</label>
                    <input type="date" id="fecha_desde" name="fecha_desde" class="form-control form-control-sm" 
                           value="{{ request('fecha_desde') }}">
                </div>

                <div class="col-md-4">
                    <label for="fecha_hasta" class="form-label">Hasta</label>
                    <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control form-control-sm"
                           value="{{ request('fecha_hasta') }}">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('propiedades.gastos.index', $propiedad) }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-redo"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de gastos --}}
    @if($gastos->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Concepto</th>
                        <th>Categoría</th>
                        <th class="text-end">Monto</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gastos as $gasto)
                        <tr>
                            <td>
                                <small class="text-muted">
                                    {{ $gasto->fecha_gasto->format('d/m/Y') }}
                                </small>
                            </td>
                            <td>
                                <strong>{{ $gasto->concepto }}</strong>
                                @if($gasto->descripcion)
                                    <br><small class="text-muted">{{ Str::limit($gasto->descripcion, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $gasto->categoria->color ?? '#6c757d' }}">
                                    {{ $gasto->categoria->nombre }}
                                </span>
                            </td>
                            <td class="text-end">
                                <strong>₡ {{ number_format($gasto->monto, 2, ',', '.') }}</strong>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('propiedades.gastos.show', [$propiedad, $gasto]) }}" 
                                   class="btn btn-sm btn-info" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('propiedades.gastos.edit', [$propiedad, $gasto]) }}" 
                                   class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('propiedades.gastos.destroy', [$propiedad, $gasto]) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Está seguro?')" 
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td class="text-end">
                            <strong>₡ {{ number_format($gastos->sum('monto'), 2, ',', '.') }}</strong>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center">
            {{ $gastos->links() }}
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle"></i>
            No hay gastos registrados para esta propiedad.
        </div>
    @endif
</div>

<script>
    // Validación del formulario
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endsection
