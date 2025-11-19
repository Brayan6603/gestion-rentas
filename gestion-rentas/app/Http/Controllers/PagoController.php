<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePagoRequest;
use App\Http\Requests\UpdatePagoRequest;
use App\Models\Pago;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of pagos for a property.
     */
    public function index(Propiedad $propiedad)
    {
        $this->authorize('view', $propiedad);

        $pagos = $propiedad->pagos()->with('inquilino')->orderByDesc('mes_correspondiente')->paginate(15);

        return view('pagos.index', compact('propiedad', 'pagos'));
    }

    /**
     * Display a global listing of pagos across propiedades.
     */
    public function indexAll(Request $request)
    {
        $this->authorize('viewAny', Pago::class);

        // Mostrar solo los pagos pertenecientes a las propiedades del usuario autenticado
        $propiedadIds = auth()->user()->propiedades()->pluck('id');

        $query = Pago::whereIn('propiedad_id', $propiedadIds)->with(['propiedad', 'inquilino']);

        // Filtros: propiedad, estado, búsqueda por inquilino
        if ($request->filled('propiedad_id')) {
            $query->where('propiedad_id', $request->input('propiedad_id'));
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->whereHas('inquilino', function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('apellido', 'like', "%{$buscar}%");
            });
        }

        // Total filtrado
        $total = (clone $query)->sum('monto');

        $pagos = $query->orderByDesc('mes_correspondiente')->paginate(20)->withQueryString();

        // Obtener propiedades del usuario para el filtro
        $propiedades = auth()->user()->propiedades()->get();

        return view('pagos.index_all', compact('pagos', 'propiedades', 'total'));
    }

    /**
     * Show the form for creating a new pago for a property.
     */
    public function create(Propiedad $propiedad, Request $request)
    {
        $this->authorize('create', [Pago::class, $propiedad]);

        $inquilinos = $propiedad->inquilinos()->get();
        
        // Obtener valores precargados desde query params si existen
        $inquilinoPreseleccionado = $request->query('inquilino_id');
        $montoPreseleccionado = $request->query('monto');

        return view('pagos.create', compact('propiedad', 'inquilinos', 'inquilinoPreseleccionado', 'montoPreseleccionado'));
    }

    /**
     * Store a newly created pago in storage.
     */
    public function store(StorePagoRequest $request, Propiedad $propiedad)
    {
        $this->authorize('create', [Pago::class, $propiedad]);

        $validated = $request->validated();
        // Verificar que el inquilino seleccionado pertenezca a la propiedad
        if (! $propiedad->inquilinos()->where('id', $validated['inquilino_id'])->exists()) {
            return back()->withErrors(['inquilino_id' => 'El inquilino seleccionado no pertenece a la propiedad.'])->withInput();
        }

        $validated['propiedad_id'] = $propiedad->id;

        $pago = Pago::create($validated);

        return redirect()->route('propiedades.pagos.index', $propiedad->id)
                         ->with('success', 'Pago registrado correctamente.');
    }

    /**
     * Display the specified pago.
     */
    public function show(Propiedad $propiedad, Pago $pago)
    {
        if ($pago->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $this->authorize('view', $pago);

        $pago->load('inquilino', 'propiedad');

        return view('pagos.show', compact('propiedad', 'pago'));
    }

    /**
     * Show the form for editing the specified pago.
     */
    public function edit(Propiedad $propiedad, Pago $pago)
    {
        if ($pago->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $this->authorize('update', $pago);

        $inquilinos = $propiedad->inquilinos()->get();

        return view('pagos.edit', compact('propiedad', 'pago', 'inquilinos'));
    }

    /**
     * Update the specified pago in storage.
     */
    public function update(UpdatePagoRequest $request, Propiedad $propiedad, Pago $pago)
    {
        if ($pago->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $this->authorize('update', $pago);

        $validated = $request->validated();
        if (! $propiedad->inquilinos()->where('id', $validated['inquilino_id'])->exists()) {
            return back()->withErrors(['inquilino_id' => 'El inquilino seleccionado no pertenece a la propiedad.'])->withInput();
        }

        $pago->update($validated);

        return redirect()->route('propiedades.pagos.show', [$propiedad->id, $pago->id])
                         ->with('success', 'Pago actualizado correctamente.');
    }

    /**
     * Remove the specified pago from storage.
     */
    public function destroy(Propiedad $propiedad, Pago $pago)
    {
        if ($pago->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $this->authorize('delete', $pago);

        $pago->delete();

        return redirect()->route('propiedades.pagos.index', $propiedad->id)
                         ->with('success', 'Pago eliminado correctamente.');
    }
}
