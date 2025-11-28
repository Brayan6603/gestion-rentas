@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Todos los Gastos</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('categoria-gastos.index') }}" class="btn btn-info">
                <i class="fas fa-tag"></i> Categorías
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
                <div class="col-md-3">
                    <label for="propiedad_id" class="form-label">Propiedad</label>
                    <select id="propiedad_id" name="propiedad_id" class="form-select form-select-sm">
                        <option value="">-- Todas --</option>
                        @foreach($propiedades as $prop)
                            <option value="{{ $prop->id }}" @selected(request('propiedad_id') == $prop->id)>
                                {{ $prop->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="categoria_gasto_id" class="form-label">Categoría</label>
                    <select id="categoria_gasto_id" name="categoria_gasto_id" class="form-select form-select-sm">
                        <option value="">-- Todas --</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" @selected(request('categoria_gasto_id') == $cat->id)>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="fecha_desde" class="form-label">Desde</label>
                    <input type="date" id="fecha_desde" name="fecha_desde" class="form-control form-control-sm" 
                           value="{{ request('fecha_desde') }}">
                </div>

                <div class="col-md-2">
                    <label for="fecha_hasta" class="form-label">Hasta</label>
                    <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control form-control-sm"
                           value="{{ request('fecha_hasta') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-sm btn-primary flex-grow-1">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('gastos.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Resumen de totales --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <h6 class="card-title text-muted">Gasto Total</h6>
                    <h3 class="text-primary">$ {{ number_format($gastos->sum('monto'), 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center border-info">
                <div class="card-body">
                    <h6 class="card-title text-muted">Cantidad de Gastos</h6>
                    <h3 class="text-info">{{ $gastos->total() }}</h3>
                </div>
            </div>
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
                        <th>Propiedad</th>
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
                                    <br><small class="text-muted">{{ Str::limit($gasto->descripcion, 40) }}</small>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('propiedades.show', $gasto->propiedad) }}" class="text-decoration-none">
                                    {{ $gasto->propiedad->nombre }}
                                </a>
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $gasto->categoria->color ?? '#6c757d' }}">
                                    {{ $gasto->categoria->nombre }}
                                </span>
                            </td>
                            <td class="text-end">
                                <strong>$ {{ number_format($gasto->monto, 2, ',', '.') }}</strong>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('propiedades.gastos.show', [$gasto->propiedad, $gasto]) }}" 
                                       class="btn btn-sm btn-info" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('propiedades.gastos.edit', [$gasto->propiedad, $gasto]) }}" 
                                       class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('propiedades.gastos.destroy', [$gasto->propiedad, $gasto]) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('¿Está seguro?')" 
                                                title="Eliminar">
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

        {{-- Paginación --}}
        <div class="d-flex justify-content-center">
            {{ $gastos->links() }}
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle"></i>
            No hay gastos registrados con estos filtros.
        </div>
    @endif
</div>
@endsection
