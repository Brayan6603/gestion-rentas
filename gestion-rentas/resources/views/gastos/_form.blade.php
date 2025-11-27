@php
    $isEdit = isset($gasto);
@endphp

<div class="card">
    <div class="card-header bg-primary-subtle">
        <h5 class="mb-0">{{ $isEdit ? 'Editar Gasto' : 'Registrar Nuevo Gasto' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ $isEdit ? route('propiedades.gastos.update', [$propiedad, $gasto]) : route('propiedades.gastos.store', $propiedad) }}" 
              method="POST" 
              class="needs-validation" 
              novalidate>
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="concepto" class="form-label">Concepto *</label>
                        <input type="text" 
                               id="concepto" 
                               name="concepto" 
                               class="form-control @error('concepto') is-invalid @enderror"
                               value="{{ old('concepto') ?? ($isEdit ? $gasto->concepto : '') }}"
                               placeholder="Ej: Reparación de tuberías"
                               required>
                        @error('concepto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto ($) *</label>
                        <input type="number" 
                               id="monto" 
                               name="monto" 
                               class="form-control @error('monto') is-invalid @enderror"
                               value="{{ old('monto') ?? ($isEdit ? $gasto->monto : '') }}"
                               placeholder="0.00"
                               step="0.01" 
                               min="0.01"
                               required>
                        @error('monto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_gasto" class="form-label">Fecha del Gasto *</label>
                        <input type="date" 
                               id="fecha_gasto" 
                               name="fecha_gasto" 
                               class="form-control @error('fecha_gasto') is-invalid @enderror"
                               value="{{ old('fecha_gasto') ?? ($isEdit ? $gasto->fecha_gasto->format('Y-m-d') : date('Y-m-d')) }}"
                               required>
                        @error('fecha_gasto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="categoria_gasto_id" class="form-label">Categoría *</label>
                        <select id="categoria_gasto_id" 
                                name="categoria_gasto_id" 
                                class="form-select @error('categoria_gasto_id') is-invalid @enderror"
                                required>
                            <option value="">-- Seleccionar Categoría --</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" 
                                        @selected(old('categoria_gasto_id') ?? ($isEdit ? $gasto->categoria_gasto_id : null) == $categoria->id || request('categoria_gasto_id') == $categoria->id)>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_gasto_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea id="descripcion" 
                                  name="descripcion" 
                                  class="form-control @error('descripcion') is-invalid @enderror"
                                  placeholder="Detalles adicionales del gasto (opcional)"
                                  rows="3">{{ old('descripcion') ?? ($isEdit ? $gasto->descripcion : '') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    {{ $isEdit ? 'Actualizar Gasto' : 'Registrar Gasto' }}
                </button>
                <a href="{{ $isEdit ? route('propiedades.gastos.show', [$propiedad, $gasto]) : route('propiedades.gastos.index', $propiedad) }}" 
                   class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
