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
    $user              = Auth::user();
    $materiasCount     = Materia::count();
    $gruposCount       = Grupo::count();
    $misInscripciones  = $user->grupos()->count();
    $misGruposProfesor = $user->esProfesor() ? Grupo::where('profesor_id', $user->id)->count() : 0;
    
    return view('dashboard', compact('materiasCount', 'gruposCount', 'misInscripciones', 'misGruposProfesor'));
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
    Route::delete('/inscripciones/{id}', [InscripcionController::class, 'destroy'])->name('inscripciones.destroy');
    
    // Calificaciones — Alumno
    Route::get('/boleta', [App\Http\Controllers\CalificacionController::class, 'miBoleta'])->name('calificaciones.boleta');
    
    // Calificaciones — Profesor
    Route::get('/calificaciones/grupos', [App\Http\Controllers\CalificacionController::class, 'misGrupos'])->name('calificaciones.grupos');
    Route::get('/calificaciones/{grupoId}/capturar', [App\Http\Controllers\CalificacionController::class, 'capturar'])->name('calificaciones.capturar');
    Route::post('/calificaciones/{grupoId}/guardar', [App\Http\Controllers\CalificacionController::class, 'guardar'])->name('calificaciones.guardar');

    // Tareas — Profesor
    Route::get('/tareas', [App\Http\Controllers\TareaController::class, 'index'])->name('tareas.index');
    Route::get('/tareas/crear', [App\Http\Controllers\TareaController::class, 'create'])->name('tareas.crear');
    Route::post('/tareas', [App\Http\Controllers\TareaController::class, 'store'])->name('tareas.store');
    Route::get('/tareas/{id}/revisar', [App\Http\Controllers\TareaController::class, 'revisar'])->name('tareas.revisar');
    Route::post('/tareas/comentar/{entregaId}', [App\Http\Controllers\TareaController::class, 'comentar'])->name('tareas.comentar');
    Route::delete('/tareas/{id}', [App\Http\Controllers\TareaController::class, 'destroy'])->name('tareas.destroy');

    // Entregas — Alumno
    Route::get('/mis-tareas', [App\Http\Controllers\EntregaController::class, 'index'])->name('entregas.index');
    Route::post('/entregas/{tareaId}', [App\Http\Controllers\EntregaController::class, 'store'])->name('entregas.store');
    Route::get('/entregas/descargar/{entregaId}', [App\Http\Controllers\EntregaController::class, 'descargar'])->name('entregas.descargar');
});

require __DIR__.'/auth.php';