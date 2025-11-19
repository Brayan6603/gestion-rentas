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
    public function indexAll()
    {
        $this->middleware('auth');

        $pagos = Pago::with(['propiedad', 'inquilino'])->orderByDesc('mes_correspondiente')->paginate(20);

        return view('pagos.index_all', compact('pagos'));
    }

    /**
     * Show the form for creating a new pago for a property.
     */
    public function create(Propiedad $propiedad)
    {
        $this->authorize('view', $propiedad);

        $inquilinos = $propiedad->inquilinos()->get();

        return view('pagos.create', compact('propiedad', 'inquilinos'));
    }

    /**
     * Store a newly created pago in storage.
     */
    public function store(StorePagoRequest $request, Propiedad $propiedad)
    {
        $this->authorize('view', $propiedad);

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
        $this->authorize('view', $propiedad);

        if ($pago->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $pago->load('inquilino', 'propiedad');

        return view('pagos.show', compact('propiedad', 'pago'));
    }

    /**
     * Show the form for editing the specified pago.
     */
    public function edit(Propiedad $propiedad, Pago $pago)
    {
        $this->authorize('view', $propiedad);

        if ($pago->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $inquilinos = $propiedad->inquilinos()->get();

        return view('pagos.edit', compact('propiedad', 'pago', 'inquilinos'));
    }

    /**
     * Update the specified pago in storage.
     */
    public function update(UpdatePagoRequest $request, Propiedad $propiedad, Pago $pago)
    {
        $this->authorize('view', $propiedad);

        if ($pago->propiedad_id !== $propiedad->id) {
            abort(404);
        }

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
        $this->authorize('view', $propiedad);

        if ($pago->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $pago->delete();

        return redirect()->route('propiedades.pagos.index', $propiedad->id)
                         ->with('success', 'Pago eliminado correctamente.');
    }
}
