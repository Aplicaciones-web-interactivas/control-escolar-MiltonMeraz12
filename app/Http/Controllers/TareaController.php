<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Grupo;
use App\Models\Entrega;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    // Lista agrupadas por grupo
    public function index()
    {
        abort_if(!Auth::user()->esProfesor(), 403);

        $grupos = Grupo::with(['materia', 'tareas.entregas'])
            ->where('profesor_id', Auth::id())
            ->get();

        return view('tareas.index', compact('grupos'));
    }

    // Formulario para crear tarea
    public function create()
    {
        abort_if(!Auth::user()->esProfesor(), 403);

        $grupos = Grupo::with('materia')
            ->where('profesor_id', Auth::id())
            ->get();

        return view('tareas.crear', compact('grupos'));
    }

    //Guardar nueva tarea
    public function store(Request $request)
    {
        abort_if(!Auth::user()->esProfesor(), 403);

        $request->validate([
            'grupo_id'     => 'required|exists:grupos,id',
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'fecha_limite' => 'required|date',
        ],
        [
            'fecha_limite.required' => 'La fecha límite es obligatoria.',
            'titulo.required' => 'El título es obligatorio.',
            'grupo_id.required' => 'Debes seleccionar un grupo.',
        ]);

        // Verificar que el grupo le pertenece al profesor
        $grupo = Grupo::findOrFail($request->grupo_id);
        abort_if($grupo->profesor_id !== Auth::id(), 403);

        Tarea::create([
            'grupo_id'     => $request->grupo_id,
            'profesor_id'  => Auth::id(),
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'fecha_limite' => $request->fecha_limite,
        ]);

        return redirect()->route('tareas.index')
            ->with('success', 'Tarea creada correctamente.');
    }

    // Ver entregas
    public function revisar($tareaId)
    {
        abort_if(!Auth::user()->esProfesor(), 403);

        $tarea = Tarea::with(['grupo.materia', 'grupo.alumnos', 'entregas.alumno'])
            ->findOrFail($tareaId);

        abort_if($tarea->profesor_id !== Auth::id(), 403);

        return view('tareas.revisar', compact('tarea'));
    }

    // Guardar comentario
    public function comentar(Request $request, $entregaId)
    {
        abort_if(!Auth::user()->esProfesor(), 403);

        $request->validate([
            'comentario_profesor' => 'nullable|string|max:1000',
        ]);

        $entrega = Entrega::with('tarea')->findOrFail($entregaId);
        abort_if($entrega->tarea->profesor_id !== Auth::id(), 403);

        $entrega->update([
            'comentario_profesor' => $request->comentario_profesor,
            'estado'              => 'revisado',
        ]);

        return back()->with('success', 'Comentario guardado.');
    }

    public function destroy($id)
    {
        abort_if(!Auth::user()->esProfesor(), 403);

        $tarea = Tarea::findOrFail($id);
        abort_if($tarea->profesor_id !== Auth::id(), 403);

        $tarea->delete();

        return back()->with('success', 'Tarea eliminada.');
    }
}