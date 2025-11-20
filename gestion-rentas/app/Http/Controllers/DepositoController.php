<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepositoRequest;
use App\Http\Requests\UpdateDepositoRequest;
use App\Models\Deposito;
use App\Models\Propiedad;
use App\Models\Inquilino;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class DepositoController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of depositos for a property.
     */
    public function index(Propiedad $propiedad)
    {
        $this->authorize('view', $propiedad);

        $depositos = $propiedad->depositos()->with('inquilino')->orderByDesc('fecha_deposito')->paginate(15);

        return view('depositos.index', compact('propiedad', 'depositos'));
    }

    /**
     * Display a global listing of depositos across propiedades.
     */
    public function indexAll(Request $request)
    {
        $this->authorize('viewAny', Deposito::class);

        $propiedadIds = auth()->user()->propiedades()->pluck('id');

        $query = Deposito::whereIn('propiedad_id', $propiedadIds)->with(['propiedad', 'inquilino']);

        // optional filters: propiedad, estado, inquilino, fecha range
        if ($request->filled('propiedad_id')) {
            $query->where('propiedad_id', $request->input('propiedad_id'));
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->filled('inquilino_id')) {
            $query->where('inquilino_id', $request->input('inquilino_id'));
        }

        if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {
            $desde = $request->input('fecha_desde');
            $hasta = $request->input('fecha_hasta');
            $query->whereBetween('fecha_deposito', [$desde, $hasta]);
        } elseif ($request->filled('fecha_desde')) {
            $query->where('fecha_deposito', '>=', $request->input('fecha_desde'));
        } elseif ($request->filled('fecha_hasta')) {
            $query->where('fecha_deposito', '<=', $request->input('fecha_hasta'));
        }

        $total = (clone $query)->sum('monto');

        $depositos = $query->orderByDesc('fecha_deposito')->paginate(20)->withQueryString();

        $propiedades = auth()->user()->propiedades()->get();
        $inquilinos = Inquilino::whereIn('propiedad_id', $propiedadIds)->get();

        return view('depositos.index_all', compact('depositos', 'propiedades', 'inquilinos', 'total'));
    }

    /**
     * Show the form for creating a new deposito for a property.
     */
    public function create(Propiedad $propiedad, Request $request)
    {
        $this->authorize('create', [Deposito::class, $propiedad]);

        $inquilinos = $propiedad->inquilinos()->get();
        
        // Obtener valores precargados desde query params si existen
        $inquilinoPreseleccionado = $request->query('inquilino_id');
        $montoPreseleccionado = $request->query('monto');

        return view('depositos.create', compact('propiedad', 'inquilinos', 'inquilinoPreseleccionado', 'montoPreseleccionado'));
    }

    /**
     * Store a newly created deposito in storage.
     */
    public function store(StoreDepositoRequest $request, Propiedad $propiedad)
    {
        $this->authorize('create', [Deposito::class, $propiedad]);

        $validated = $request->validated();
        // Verificar que el inquilino seleccionado pertenezca a la propiedad
        if (! $propiedad->inquilinos()->where('id', $validated['inquilino_id'])->exists()) {
            return back()->withErrors(['inquilino_id' => 'El inquilino seleccionado no pertenece a la propiedad.'])->withInput();
        }

        $validated['propiedad_id'] = $propiedad->id;

        $deposito = Deposito::create($validated);

        return redirect()->route('propiedades.depositos.index', $propiedad->id)
                         ->with('success', 'Depósito registrado correctamente.');
    }

    /**
     * Display the specified deposito.
     */
    public function show(Propiedad $propiedad, Deposito $deposito)
    {
        if ($deposito->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $this->authorize('view', $deposito);

        $deposito->load('inquilino', 'propiedad');

        return view('depositos.show', compact('propiedad', 'deposito'));
    }

    /**
     * Show the form for editing the specified deposito.
     */
    public function edit(Propiedad $propiedad, Deposito $deposito)
    {
        if ($deposito->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $this->authorize('update', $deposito);

        $inquilinos = $propiedad->inquilinos()->get();

        return view('depositos.edit', compact('propiedad', 'deposito', 'inquilinos'));
    }

    /**
     * Update the specified deposito in storage.
     */
    public function update(UpdateDepositoRequest $request, Propiedad $propiedad, Deposito $deposito)
    {
        if ($deposito->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $this->authorize('update', $deposito);

        $validated = $request->validated();
        if (! $propiedad->inquilinos()->where('id', $validated['inquilino_id'])->exists()) {
            return back()->withErrors(['inquilino_id' => 'El inquilino seleccionado no pertenece a la propiedad.'])->withInput();
        }

        $deposito->update($validated);

        return redirect()->route('propiedades.depositos.show', [$propiedad->id, $deposito->id])
                         ->with('success', 'Depósito actualizado correctamente.');
    }

    /**
     * Remove the specified deposito from storage.
     */
    public function destroy(Propiedad $propiedad, Deposito $deposito)
    {
        if ($deposito->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $this->authorize('delete', $deposito);

        $deposito->delete();

        return redirect()->route('propiedades.depositos.index', $propiedad->id)
                         ->with('success', 'Depósito eliminado correctamente.');
    }
}
