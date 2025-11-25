@php
    $isEdit = isset($categoriaGasto);
@endphp

<div class="card">
    <div class="card-header bg-primary-subtle">
        <h5 class="mb-0">{{ $isEdit ? 'Editar Categoría de Gasto' : 'Nueva Categoría de Gasto' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ $isEdit ? route('categoria-gastos.update', $categoriaGasto) : route('categoria-gastos.store') }}" 
              method="POST" 
              class="needs-validation" 
              novalidate>
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre *</label>
                <input type="text" 
                       id="nombre" 
                       name="nombre" 
                       class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre') ?? $categoriaGasto->nombre ?? '' }}"
                       placeholder="Ej: Mantenimiento, Servicios, Impuestos"
                       required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea id="descripcion" 
                          name="descripcion" 
                          class="form-control @error('descripcion') is-invalid @enderror"
                          placeholder="Detalles sobre esta categoría (opcional)"
                          rows="3">{{ old('descripcion') ?? $categoriaGasto->descripcion ?? '' }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="color" class="form-label">Color de Identificación</label>
                <input type="color" 
                       id="color" 
                       name="color" 
                       class="form-control form-control-color @error('color') is-invalid @enderror"
                       value="{{ old('color') ?? $categoriaGasto->color ?? '#6c757d' }}"
                       style="width: 80px; height: 40px;">
                @error('color')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    {{ $isEdit ? 'Actualizar Categoría' : 'Crear Categoría' }}
                </button>
                <a href="{{ $isEdit ? route('categoria-gastos.show', $categoriaGasto) : route('categoria-gastos.index') }}" 
                   class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
