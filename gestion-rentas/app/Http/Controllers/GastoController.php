<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use App\Models\Propiedad;
use App\Models\CategoriaGasto;
use App\Http\Requests\StoreGastoRequest;
use App\Http\Requests\UpdateGastoRequest;

class GastoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Nested resource actions (property-scoped)
    public function index(Propiedad $propiedad)
    {
        $this->authorize('view', $propiedad);

        $gastos = $propiedad->gastos()
            ->with('categoria')
            ->orderByDesc('fecha_gasto')
            ->paginate(20);

        $categorias = CategoriaGasto::orderBy('nombre')->get();

        return view('gastos.index', compact('propiedad', 'gastos', 'categorias'));
    }

    public function create(Propiedad $propiedad)
    {
        $this->authorize('view', $propiedad);

        $categorias = CategoriaGasto::orderBy('nombre')->get();
        
        $categoriaGastoId = request('categoria_gasto_id');
        $monto = request('monto');

        return view('gastos.create', compact('propiedad', 'categorias', 'categoriaGastoId', 'monto'));
    }

    public function store(Propiedad $propiedad, StoreGastoRequest $request)
    {
        $this->authorize('view', $propiedad);

        $propiedad->gastos()->create($request->validated());

        return redirect()->route('propiedades.gastos.index', $propiedad)
            ->with('success', 'Gasto registrado exitosamente.');
    }

    public function show(Propiedad $propiedad, Gasto $gasto)
    {
        $this->authorize('view', $gasto);
        $this->authorize('view', $propiedad);

        $gasto->load('categoria');

        return view('gastos.show', compact('propiedad', 'gasto'));
    }

    public function edit(Propiedad $propiedad, Gasto $gasto)
    {
        $this->authorize('update', $gasto);
        $this->authorize('view', $propiedad);

        $categorias = CategoriaGasto::orderBy('nombre')->get();

        return view('gastos.edit', compact('propiedad', 'gasto', 'categorias'));
    }

    public function update(Propiedad $propiedad, Gasto $gasto, UpdateGastoRequest $request)
    {
        $this->authorize('update', $gasto);
        $this->authorize('view', $propiedad);

        $gasto->update($request->validated());

        return redirect()->route('propiedades.gastos.show', [$propiedad, $gasto])
            ->with('success', 'Gasto actualizado exitosamente.');
    }

    public function destroy(Propiedad $propiedad, Gasto $gasto)
    {
        $this->authorize('delete', $gasto);
        $this->authorize('view', $propiedad);

        $gasto->delete();

        return redirect()->route('propiedades.gastos.index', $propiedad)
            ->with('success', 'Gasto eliminado exitosamente.');
    }

    // Global index view for all expenses
    public function indexAll()
    {
        $this->authorize('viewAny', Gasto::class);

        $query = Gasto::with(['propiedad', 'categoria']);

        // Filter by category
        if (request('categoria_gasto_id')) {
            $query->where('categoria_gasto_id', request('categoria_gasto_id'));
        }

        // Filter by property
        if (request('propiedad_id')) {
            $query->where('propiedad_id', request('propiedad_id'));
        }

        // Filter by date range
        if (request('fecha_desde')) {
            $query->where('fecha_gasto', '>=', request('fecha_desde'));
        }

        if (request('fecha_hasta')) {
            $query->where('fecha_gasto', '<=', request('fecha_hasta'));
        }

        // Filter by amount range
        if (request('monto_desde')) {
            $query->where('monto', '>=', request('monto_desde'));
        }

        if (request('monto_hasta')) {
            $query->where('monto', '<=', request('monto_hasta'));
        }

        $gastos = $query->orderByDesc('fecha_gasto')->paginate(30)->withQueryString();

        $categorias = CategoriaGasto::orderBy('nombre')->get();
        $propiedades = Propiedad::where('estado', 'activo')->orderBy('nombre')->get();

        return view('gastos.index-all', compact('gastos', 'categorias', 'propiedades'));
    }
}
