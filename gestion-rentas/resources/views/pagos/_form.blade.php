@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Inquilino</label>
        <select name="inquilino_id" class="form-select">
            <option value="">-- Seleccione --</option>
            @foreach($inquilinos as $inquilino)
                <option value="{{ $inquilino->id }}" {{ old('inquilino_id', $inquilinoPreseleccionado ?? $pago->inquilino_id ?? '') == $inquilino->id ? 'selected' : '' }}>
                    {{ $inquilino->nombre }} {{ $inquilino->apellido ?? '' }}
                </option>
            @endforeach
        </select>
        @error('inquilino_id') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Monto</label>
        <input type="number" step="0.01" name="monto" id="monto" class="form-control" value="{{ old('monto', $montoPreseleccionado ?? $pago->monto ?? $propiedad->renta_mensual ?? '') }}" placeholder="0.00">
        @error('monto') <div class="text-danger small">{{ $message }}</div> @enderror
        <div class="form-text" id="monto-help"></div>
    </div>

    <div class="col-md-3">
        <label class="form-label">Estado</label>
        <select name="estado" id="estado" class="form-select">
            <option value="pendiente" {{ old('estado', $pago->estado ?? '') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="pagado" {{ old('estado', $pago->estado ?? '') == 'pagado' ? 'selected' : '' }}>Pagado</option>
            <option value="parcial" {{ old('estado', $pago->estado ?? '') == 'parcial' ? 'selected' : '' }}>Pagado parcialmente</option>
            <option value="vencido" {{ old('estado', $pago->estado ?? '') == 'vencido' ? 'selected' : '' }}>Vencido</option>
        </select>
        @error('estado') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Mes correspondiente</label>
        <input type="month" name="mes_correspondiente" class="form-control" value="{{ old('mes_correspondiente', isset($pago->mes_correspondiente) ? $pago->mes_correspondiente->format('Y-m') : '') }}">
        @error('mes_correspondiente') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Fecha de pago</label>
        <input type="date" name="fecha_pago" class="form-control" value="{{ old('fecha_pago', isset($pago->fecha_pago) ? $pago->fecha_pago->format('Y-m-d') : '') }}">
        @error('fecha_pago') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <button class="btn btn-primary">Guardar</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">Cancelar</a>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const estadoSelect = document.getElementById('estado');
        const montoInput = document.getElementById('monto');
        const montoHelp = document.getElementById('monto-help');
        const rentaBase = {{ (float) ($propiedad->renta_mensual ?? 0) }};

        function formatNumber(n) {
            return n.toLocaleString('es-CR', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
        }

        function actualizarAyudaSegunEstado() {
            if (!estadoSelect || !montoInput || rentaBase <= 0) return;

            if (estadoSelect.value === 'vencido') {
                const penalizacion = rentaBase * 0.10;
                const total = rentaBase + penalizacion;

                // En vencido siempre forzamos renta + 10%
                montoInput.value = total.toFixed(2);

                const baseStr = formatNumber(rentaBase);
                const penStr = formatNumber(penalizacion);
                montoHelp.textContent = `${baseStr} + ${penStr}`;
            } else if (estadoSelect.value === 'parcial') {
                // En parcial NO tocamos el valor, solo mostramos ayuda
                const pagado = parseFloat(montoInput.value || 0);
                const restante = Math.max(rentaBase - pagado, 0);

                const rentaStr = formatNumber(rentaBase);
                const restanteStr = formatNumber(restante);
                montoHelp.textContent = `Renta: ${rentaStr} | Restante: ${restanteStr}`;
            } else {
                // Otros estados: no modificamos el monto
                montoHelp.textContent = '';
            }
        }

        if (estadoSelect) {
            estadoSelect.addEventListener('change', function () {
                actualizarAyudaSegunEstado();
            });
        }

        if (montoInput) {
            montoInput.addEventListener('input', function () {
                if (estadoSelect && estadoSelect.value === 'parcial') {
                    actualizarAyudaSegunEstado();
                }
            });
        }

        // Aplicar al cargar según el estado inicial
        actualizarAyudaSegunEstado();
    });
</script>
@endpush
