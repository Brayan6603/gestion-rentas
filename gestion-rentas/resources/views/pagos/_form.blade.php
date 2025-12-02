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
        const montoOriginal = montoInput ? parseFloat(montoInput.value || 0) : 0;
        let ultimoEstado = estadoSelect ? estadoSelect.value : null;

        function formatNumber(n) {
            return n.toLocaleString('es-CR', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
        }

        function actualizarAyudaSegunEstado() {
            if (!estadoSelect || !montoInput) return;

            const estadoActual = estadoSelect.value;

            if (estadoActual === 'vencido' && rentaBase > 0) {
                const penalizacion = rentaBase * 0.10;
                const total = rentaBase + penalizacion;

                // En vencido siempre forzamos renta + 10%
                montoInput.value = total.toFixed(2);

                const baseStr = formatNumber(rentaBase);
                const penStr = formatNumber(penalizacion);
                montoHelp.textContent = `${baseStr} + ${penStr}`;
            } else if (estadoActual === 'parcial' && rentaBase > 0) {
                // Si venimos de vencido, restauramos el monto original primero
                if (ultimoEstado === 'vencido' && !isNaN(montoOriginal) && montoOriginal > 0) {
                    montoInput.value = montoOriginal.toFixed(2);
                }

                const pagadoAhora = parseFloat(montoInput.value || 0);
                // En parcial usamos la renta mensual como referencia para total y restante
                const restante = Math.max(rentaBase - pagadoAhora, 0);

                const totalStr = formatNumber(rentaBase);
                const restanteStr = formatNumber(restante);
                montoHelp.textContent = `Total renta: ${totalStr} | Restante: ${restanteStr}`;
            } else {
                // Pendiente o Pagado: usar renta base como referencia en el input
                if (rentaBase > 0) {
                    montoInput.value = rentaBase.toFixed(2);
                } else if (!isNaN(montoOriginal) && montoOriginal > 0) {
                    // Si no hay renta definida, caer de vuelta al monto original
                    montoInput.value = montoOriginal.toFixed(2);
                }
                montoHelp.textContent = '';
            }
        }

        if (estadoSelect) {
            estadoSelect.addEventListener('change', function () {
                actualizarAyudaSegunEstado();
                ultimoEstado = estadoSelect.value;
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
