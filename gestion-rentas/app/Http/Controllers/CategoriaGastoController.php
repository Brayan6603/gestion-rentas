<?php

namespace App\Http\Controllers;

use App\Models\CategoriaGasto;
use App\Http\Requests\StoreCategoriaGastoRequest;
use App\Http\Requests\UpdateCategoriaGastoRequest;

class CategoriaGastoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('viewAny', CategoriaGasto::class);
        
        $categorias = CategoriaGasto::withCount('gastos')
            ->orderBy('nombre')
            ->paginate(15);

        return view('categorias-gasto.index', compact('categorias'));
    }

    public function create()
    {
        $this->authorize('create', CategoriaGasto::class);

        return view('categorias-gasto.create');
    }

    public function store(StoreCategoriaGastoRequest $request)
    {
        $this->authorize('create', CategoriaGasto::class);

        CategoriaGasto::create($request->validated());

        return redirect()->route('categoria-gastos.index')
            ->with('success', 'Categoría de gasto creada exitosamente.');
    }

    public function show(CategoriaGasto $categoriaGasto)
    {
        $this->authorize('view', $categoriaGasto);

        $categoriaGasto->load(['gastos' => function ($query) {
            $query->with('propiedad')->orderByDesc('fecha_gasto')->paginate(20);
        }]);

        return view('categorias-gasto.show', compact('categoriaGasto'));
    }

    public function edit(CategoriaGasto $categoriaGasto)
    {
        $this->authorize('update', $categoriaGasto);

        return view('categorias-gasto.edit', compact('categoriaGasto'));
    }

    public function update(UpdateCategoriaGastoRequest $request, CategoriaGasto $categoriaGasto)
    {
        $this->authorize('update', $categoriaGasto);

        $categoriaGasto->update($request->validated());

        return redirect()->route('categoria-gastos.show', $categoriaGasto)
            ->with('success', 'Categoría de gasto actualizada exitosamente.');
    }

    public function destroy(CategoriaGasto $categoriaGasto)
    {
        $this->authorize('delete', $categoriaGasto);

        $categoriaGasto->delete();

        return redirect()->route('categoria-gastos.index')
            ->with('success', 'Categoría de gasto eliminada exitosamente.');
    }
}
