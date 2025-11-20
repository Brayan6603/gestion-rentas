@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Inquilino</label>
        <select name="inquilino_id" class="form-select">
            <option value="">-- Seleccione --</option>
            @foreach($inquilinos as $inquilino)
                <option value="{{ $inquilino->id }}" {{ old('inquilino_id', $inquilinoPreseleccionado ?? $deposito->inquilino_id ?? '') == $inquilino->id ? 'selected' : '' }}>
                    {{ $inquilino->nombre }} {{ $inquilino->apellido ?? '' }}
                </option>
            @endforeach
        </select>
        @error('inquilino_id') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Monto</label>
        <input type="number" step="0.01" name="monto" class="form-control" value="{{ old('monto', $montoPreseleccionado ?? $deposito->monto ?? '') }}" placeholder="0.00">
        @error('monto') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select">
            <option value="activo" {{ old('estado', $deposito->estado ?? '') == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="devuelto" {{ old('estado', $deposito->estado ?? '') == 'devuelto' ? 'selected' : '' }}>Devuelto</option>
            <option value="parcial" {{ old('estado', $deposito->estado ?? '') == 'parcial' ? 'selected' : '' }}>Parcial</option>
        </select>
        @error('estado') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Fecha Depósito</label>
        <input type="date" name="fecha_deposito" class="form-control" value="{{ old('fecha_deposito', isset($deposito->fecha_deposito) ? $deposito->fecha_deposito->format('Y-m-d') : '') }}">
        @error('fecha_deposito') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Fecha Devolución</label>
        <input type="date" name="fecha_devolucion" class="form-control" value="{{ old('fecha_devolucion', isset($deposito->fecha_devolucion) ? $deposito->fecha_devolucion->format('Y-m-d') : '') }}">
        @error('fecha_devolucion') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Monto Devuelto</label>
        <input type="number" step="0.01" name="monto_devuelto" class="form-control" value="{{ old('monto_devuelto', $deposito->monto_devuelto ?? '') }}" placeholder="0.00">
        @error('monto_devuelto') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Observaciones</label>
        <textarea name="observaciones" class="form-control" rows="2" placeholder="Notas adicionales...">{{ old('observaciones', $deposito->observaciones ?? '') }}</textarea>
        @error('observaciones') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Concepto de Retención</label>
        <textarea name="concepto_retencion" class="form-control" rows="2" placeholder="Si aplica retención, describe el motivo...">{{ old('concepto_retencion', $deposito->concepto_retencion ?? '') }}</textarea>
        @error('concepto_retencion') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <button class="btn btn-primary">Guardar</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">Cancelar</a>
    </div>
</div>
