<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropiedadController;
use App\Http\Controllers\InquilinoController;
use App\Http\Controllers\PagoController;
use App\Models\Propiedad;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/debug-propiedad/{id}', function($id) {
    $propiedad = Propiedad::find($id);
    
    return response()->json([
        'propiedad_id' => $propiedad->id,
        'user_id_en_propiedad' => $propiedad->user_id,
        'user_relation_loaded' => $propiedad->relationLoaded('user'),
        'user_via_relation' => $propiedad->user ? $propiedad->user->id : 'null',
        'auth_user_id' => auth()->id(),
        'son_iguales' => $propiedad->user_id === auth()->id()
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Ruta para ver todos los inquilinos
    Route::get('/inquilinos', [InquilinoController::class, 'indexAll'])->name('inquilinos.index');
    Route::get('/inquilinos/crear', [InquilinoController::class, 'createAll'])->name('inquilinos.createAll');
    Route::post('/inquilinos', [InquilinoController::class, 'storeAll'])->name('inquilinos.storeAll');
    
    Route::resource('propiedades', PropiedadController::class)->parameters([
        'propiedades' => 'propiedad'
    ]);
    
    // Rutas anidadas para inquilinos dentro de propiedades
    Route::resource('propiedades.inquilinos', InquilinoController::class)->parameters([
        'propiedades' => 'propiedad',
        'inquilinos' => 'inquilino'
    ]);

    // Rutas para pagos
    // Ruta global para listar todos los pagos (enlace del offcanvas)
    Route::get('pagos', [PagoController::class, 'indexAll'])->name('pagos.index');

    // Rutas anidadas para pagos dentro de propiedades
    Route::resource('propiedades.pagos', PagoController::class)->parameters([
        'propiedades' => 'propiedad',
        'pagos' => 'pago'
    ]);
});




require __DIR__.'/auth.php';
