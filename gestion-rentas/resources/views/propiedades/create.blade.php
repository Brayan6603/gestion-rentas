@extends('layouts.app')

@section('title', 'Agregar Nueva Propiedad')

@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle me-2"></i>Agregar Nueva Propiedad
        </h1>
        <a href="{{ route('propiedades.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Volver a la lista
        </a>
    </div>

    <!-- Formulario -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Información de la Propiedad
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('propiedades.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre de la Propiedad *</label>
                                <input type="text" 
                                       class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="{{ old('nombre') }}" 
                                       required 
                                       placeholder="Ej: Departamento 101">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tipo -->
                            <div class="col-md-6 mb-3">
                                <label for="tipo" class="form-label">Tipo de Propiedad *</label>
                                <select class="form-select @error('tipo') is-invalid @enderror" 
                                        id="tipo" 
                                        name="tipo" 
                                        required>
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="departamento" {{ old('tipo') == 'departamento' ? 'selected' : '' }}>Departamento</option>
                                    <option value="casa" {{ old('tipo') == 'casa' ? 'selected' : '' }}>Casa</option>
                                    <option value="local" {{ old('tipo') == 'local' ? 'selected' : '' }}>Local Comercial</option>
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección Completa *</label>
                            <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                      id="direccion" 
                                      name="direccion" 
                                      rows="3" 
                                      required 
                                      placeholder="Dirección completa de la propiedad">{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Renta Mensual -->
                            <div class="col-md-6 mb-3">
                                <label for="renta_mensual" class="form-label">Renta Mensual *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           step="0.01" 
                                           min="0"
                                           class="form-control @error('renta_mensual') is-invalid @enderror" 
                                           id="renta_mensual" 
                                           name="renta_mensual" 
                                           value="{{ old('renta_mensual') }}" 
                                           required 
                                           placeholder="0.00">
                                </div>
                                @error('renta_mensual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Monto mensual de renta</div>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">Estado *</label>
                                <select class="form-select @error('estado') is-invalid @enderror" 
                                        id="estado" 
                                        name="estado" 
                                        required>
                                    <option value="">Seleccionar estado...</option>
                                    <option value="disponible" {{ old('estado') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                    <option value="rentada" {{ old('estado') == 'rentada' ? 'selected' : '' }}>Rentada</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <label for="descripcion" class="form-label">Descripción (Opcional)</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" 
                                      name="descripcion" 
                                      rows="4" 
                                      placeholder="Características adicionales de la propiedad...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Describe las características, servicios incluidos, amenidades, etc.</div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('propiedades.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Propiedad
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script para mejorar la experiencia del usuario
    document.addEventListener('DOMContentLoaded', function() {
        // Formatear automáticamente el campo de renta
        const rentaInput = document.getElementById('renta_mensual');
        rentaInput.addEventListener('blur', function() {
            if (this.value) {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });

        // Validación en tiempo real
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                const requiredFields = form.querySelectorAll('[required]');
                let valid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        valid = false;
                        field.classList.add('is-invalid');
                    }
                });

                if (!valid) {
                    event.preventDefault();
                    alert('Por favor, complete todos los campos requeridos.');
                }
            });
        });
    });
</script>
@endpush