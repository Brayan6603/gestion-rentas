<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class PropiedadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propiedades = Propiedad::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('propiedades.index', compact('propiedades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('propiedades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'renta_mensual' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:1000',
            'tipo' => ['required', Rule::in(['departamento', 'casa', 'local'])],
            'estado' => ['required', Rule::in(['disponible', 'rentada'])],
        ]);

        // Asignar el usuario autenticado
        $validated['user_id'] = auth()->id();

        Propiedad::create($validated);

        return redirect()->route('propiedades.index')
            ->with('success', 'Propiedad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Propiedad $propiedad)
    {
        // dd([
        // 'user_id_autenticado' => auth()->id(),
        // 'user_id_propiedad' => $propiedad->user_id,
        // 'son_iguales' => auth()->id() === $propiedad->user_id,
        // 'propiedad' => $propiedad
   // ]);
        // Verificar que la propiedad pertenezca al usuario autenticado
        $this->authorize('view', $propiedad);

        // Asegurar que se recargue desde BD para reflejar cambios recientes
        $propiedad->refresh();

        $propiedad->load(['inquilinos', 'pagos' => function ($query) {
            $query->orderBy('fecha_pago', 'desc')->limit(5);
        }, 'gastos' => function ($query) {
            $query->orderBy('fecha_gasto', 'desc')->limit(5);
        }]);

        return view('propiedades.show', compact('propiedad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Propiedad $propiedad)
    {
        // Verificar que la propiedad pertenezca al usuario autenticado
        $this->authorize('update', $propiedad);

        return view('propiedades.edit', compact('propiedad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Propiedad $propiedad)
    {
        // Verificar que la propiedad pertenezca al usuario autenticado
        $this->authorize('update', $propiedad);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'renta_mensual' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:1000',
            'tipo' => ['required', Rule::in(['departamento', 'casa', 'local'])],
            'estado' => ['required', Rule::in(['disponible', 'rentada'])],
        ]);

        $propiedad->update($validated);

        return redirect()->route('propiedades.index')
            ->with('success', 'Propiedad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Propiedad $propiedad)
    {
        // Verificar que la propiedad pertenezca al usuario autenticado
        $this->authorize('delete', $propiedad);

        // Verificar que no tenga relaciones dependientes
        if ($propiedad->inquilinos()->exists()) {
            return redirect()->route('propiedades.index')
                ->with('error', 'No se puede eliminar la propiedad porque tiene inquilinos asociados.');
        }

        if ($propiedad->pagos()->exists()) {
            return redirect()->route('propiedades.index')
                ->with('error', 'No se puede eliminar la propiedad porque tiene pagos registrados.');
        }

        $propiedad->delete();

        return redirect()->route('propiedades.index')
            ->with('success', 'Propiedad eliminada exitosamente.');
    }

    /**
     * Cambiar el estado de la propiedad
     */
    public function cambiarEstado(Request $request, Propiedad $propiedad)
    {
        $this->authorize('update', $propiedad);

        $request->validate([
            'estado' => ['required', Rule::in(['disponible', 'rentada'])],
        ]);

        $propiedad->update(['estado' => $request->estado]);

        return redirect()->back()
            ->with('success', 'Estado de la propiedad actualizado exitosamente.');
    }
}