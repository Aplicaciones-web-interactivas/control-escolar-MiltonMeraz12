<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EntregaController extends Controller
{
    // Alumno -> Ver pendientes y entregadas
    public function index()
    {
        abort_if(!Auth::user()->esAlumno(), 403);

        $user = Auth::user();

        $grupos = $user->grupos()
            ->with(['materia', 'tareas'])
            ->get();
 
        // IDs de tareas que el alumno ya entregó
        $entregasDelAlumno = Entrega::where('alumno_id', $user->id)
            ->get()
            ->keyBy('tarea_id');

        return view('entregas.index', compact('grupos', 'entregasDelAlumno'));
    }

    // Alumno -> PDF
    public function store(Request $request, $tareaId)
    {
        abort_if(!Auth::user()->esAlumno(), 403);

        $tarea = Tarea::findOrFail($tareaId);
        $user  = Auth::user();

        // Verificar que el alumno pertenece al grupo de la tarea
        abort_if(!$user->grupos()->where('grupo_id', $tarea->grupo_id)->exists(), 403);

        // Verificar que no haya entregado
        if ($tarea->yaEntrego($user->id)) {
            return back()->with('error', 'Ya entregaste esta tarea.');
        }

        // Verificar que no esté vencida
        if ($tarea->vencida()) {
            return back()->with('error', 'La fecha límite de esta tarea ya pasó.');
        }

        $request->validate([
            'archivo' => 'required|file|mimes:pdf|max:5120', // max 5MB
        ]);

        $ruta = $request->file('archivo')->store('', 'private');

        Entrega::create([
            'tarea_id'  => $tarea->id,
            'alumno_id' => $user->id,
            'archivo'   => $ruta,
            'estado'    => 'entregado',
        ]);

        return back()->with('success', 'Tarea entregada correctamente.');
    }

    // Descargar PDF
    public function descargar($entregaId)
    {
        $entrega = Entrega::with('tarea')->findOrFail($entregaId);
        $user    = Auth::user();

        $esProfesorDelGrupo = $user->esProfesor()
            && $entrega->tarea->profesor_id === $user->id;

        $esElAlumno = $user->esAlumno()
            && $entrega->alumno_id === $user->id;

        abort_if(!$esProfesorDelGrupo && !$esElAlumno, 403);

        return Storage::disk('private')->download(
            $entrega->archivo,
            'entrega_' . $entrega->alumno_id . '_tarea_' . $entrega->tarea_id . '.pdf'
        );
    }
}