<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquilinoRequest;
use App\Http\Requests\UpdateInquilinoRequest;
use App\Models\Inquilino;
use App\Models\Propiedad;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InquilinoController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of all inquilinos for the authenticated user.
     */
    public function indexAll(\Illuminate\Http\Request $request)
    {
        // Obtener todas las propiedades del usuario autenticado con sus inquilinos
        $propiedades = auth()->user()->propiedades()->with('inquilinos')->get();

        $propiedadIds = $propiedades->pluck('id');

        // Base query: todos los inquilinos del usuario
        $query = Inquilino::whereIn('propiedad_id', $propiedadIds)
                          ->with('propiedad');

        // Filtro de búsqueda por nombre o email
        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        // Paginación con query string para mantener el término de búsqueda
        $inquilinos = $query->paginate(15)->withQueryString();

        return view('inquilinos.index-all', compact('inquilinos', 'propiedades'));
    }
    //hola
    /**
     * Show the form for creating a new inquilino from the index-all view.
     */
    public function createAll()
    {
        // Obtener todas las propiedades del usuario autenticado
        $propiedades = auth()->user()->propiedades()->get();

        return response()->json([
            'propiedades' => $propiedades
        ]);
    }

    /**
     * Store a newly created inquilino from the index-all view.
     */
    public function storeAll(StoreInquilinoRequest $request)
    {
        $validated = $request->validated();
        
        // Verificar que la propiedad pertenece al usuario autenticado
        $propiedad = Propiedad::findOrFail($validated['propiedad_id']);
        $this->authorize('view', $propiedad);

        $inquilino = Inquilino::create($validated);

        return redirect()
                ->route('inquilinos.index')
                ->with('success', 'Inquilino creado exitosamente.');
    }

    /**
     * Display a listing of the inquilinos for a specific propiedad.
     */
    public function index(Propiedad $propiedad)
    {
        $this->authorize('view', $propiedad);

        $inquilinos = $propiedad->inquilinos()->paginate(10);

        return view('inquilinos.index', compact('propiedad', 'inquilinos'));
    }

    /**
     * Show the form for creating a new inquilino.
     */
    public function create(Propiedad $propiedad)
    {
        $this->authorize('create', [Inquilino::class, $propiedad]);

        return view('inquilinos.create', compact('propiedad'));
    }

    /**
     * Store a newly created inquilino in storage.
     */
    public function store(StoreInquilinoRequest $request, Propiedad $propiedad)
    {
        $this->authorize('create', [Inquilino::class, $propiedad]);

        $validated = $request->validated();
        $validated['propiedad_id'] = $propiedad->id;

        $inquilino = Inquilino::create($validated);

        return redirect()
                ->route('propiedades.inquilinos.show', [$propiedad->id, $inquilino->id])
                ->with('success', 'Inquilino creado exitosamente.');
    }

    /**
     * Display the specified inquilino.
     */
    public function show(Propiedad $propiedad, Inquilino $inquilino)
    {
        $this->authorize('view', $inquilino);

        // Validar que el inquilino pertenece a la propiedad
        if ($inquilino->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $pagos = $inquilino->pagos()->paginate(10);
        $depositos = $inquilino->depositos()->paginate(10);

        return view('inquilinos.show', compact('propiedad', 'inquilino', 'pagos', 'depositos'));
    }

    /**
     * Show the form for editing the specified inquilino.
     */
    public function edit(Propiedad $propiedad, Inquilino $inquilino)
    {
        $this->authorize('update', $inquilino);

        // Validar que el inquilino pertenece a la propiedad
        if ($inquilino->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        return view('inquilinos.edit', compact('propiedad', 'inquilino'));
    }

    /**
     * Update the specified inquilino in storage.
     */
    public function update(UpdateInquilinoRequest $request, Propiedad $propiedad, Inquilino $inquilino)
    {
        $this->authorize('update', $inquilino);

        // Validar que el inquilino pertenece a la propiedad
        if ($inquilino->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $validated = $request->validated();
        $inquilino->update($validated);

        return redirect()
                ->route('propiedades.inquilinos.show', [$propiedad->id, $inquilino->id])
                ->with('success', 'Inquilino actualizado exitosamente.');
    }

    /**
     * Remove the specified inquilino from storage.
     */
    public function destroy(Propiedad $propiedad, Inquilino $inquilino)
    {
        $this->authorize('delete', $inquilino);

        // Validar que el inquilino pertenece a la propiedad
        if ($inquilino->propiedad_id !== $propiedad->id) {
            abort(404);
        }

        $inquilino->delete();

        return redirect()
                ->route('propiedades.inquilinos.index', $propiedad->id)
                ->with('success', 'Inquilino eliminado exitosamente.');
    }
}
