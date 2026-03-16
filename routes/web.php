<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\InscripcionController;
use App\Models\Materia;
use App\Models\Grupo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $materiasCount = Materia::count();
    $gruposCount = Grupo::count();
    $misInscripciones = auth()->user()->grupos()->count();
    
    return view('dashboard', compact('materiasCount', 'gruposCount', 'misInscripciones'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Todas las rutas protegidas por login
Route::middleware('auth')->group(function () {
    
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD de Materias
    Route::get('/materias', [MateriaController::class, 'index'])->name('materias.index');
    Route::post('/materias', [MateriaController::class, 'store'])->name('materias.store');
    Route::put('/materias/{id}', [MateriaController::class, 'update'])->name('materias.update'); // <-- NUEVA
    Route::post('/materias/eliminar/{id}', [MateriaController::class, 'destroy'])->name('materias.destroy');

    // CRUD de Grupos y Horarios
    Route::get('/grupos', [GrupoController::class, 'index'])->name('grupos.index');
    Route::post('/grupos', [GrupoController::class, 'store'])->name('grupos.store');
    Route::put('/grupos/{id}', [GrupoController::class, 'update'])->name('grupos.update'); // <-- NUEVA
    Route::post('/grupos/eliminar/{id}', [GrupoController::class, 'destroy'])->name('grupos.destroy');

    // Inscripciones
    Route::get('/mi-horario', [InscripcionController::class, 'index'])->name('inscripciones.index');
    Route::post('/inscripciones', [InscripcionController::class, 'store'])->name('inscripciones.store');
    Route::post('/inscripciones/baja/{id}', [InscripcionController::class, 'destroy'])->name('inscripciones.destroy');
});

require __DIR__.'/auth.php';