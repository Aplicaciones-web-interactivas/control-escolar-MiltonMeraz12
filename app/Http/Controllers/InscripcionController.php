<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscripcionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $misGrupos = $user->grupos()->with(['materia', 'calificaciones' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }])->get();
        
        $misGruposIds = $misGrupos->pluck('id')->toArray();

        $query = Grupo::with(['materia', 'alumnos'])
            ->whereNotIn('id', $misGruposIds);
 
        if ($request->filled('buscar')) {
            $query->whereHas('materia', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->buscar . '%');
            });
        }
 
        if ($request->filled('semestre')) {
            $query->whereHas('materia', function ($q) use ($request) {
                $q->where('semestre', $request->semestre);
            });
        }
 
        if ($request->filled('area')) {
            $query->whereHas('materia', function ($q) use ($request) {
                $q->where('area', $request->area);
            });
        }
 
        $gruposDisponibles = $query->get();
 
        $semestres = \App\Models\Materia::distinct()->pluck('semestre')->sort()->values();
        $areas     = \App\Models\Materia::distinct()->pluck('area')->filter()->sort()->values();

        return view('inscripciones.index', compact('misGrupos', 'gruposDisponibles', 'semestres', 'areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id'
        ]);

        $user = Auth::user();
        $grupo = Grupo::with(['materia', 'alumnos'])->findOrFail($request->grupo_id);

        if ($user->grupos()->where('grupo_id', $grupo->id)->exists()) {
            return back()->with('error', 'Ya estás inscrito en este grupo.');
        }

        if (!$grupo->tieneCupo()) {
            return back()->with('error', 'Lo sentimos, este grupo ya no tiene cupo disponible.');
        }

        if ($grupo->hora_inicio && $grupo->hora_fin) {
            $misGruposActuales = $user->grupos()->get();
 
            foreach ($misGruposActuales as $miGrupo) {
                if (!$miGrupo->hora_inicio || !$miGrupo->hora_fin) continue;
 
                $diasNuevo    = explode(',', $grupo->dias ?? '');
                $diasExistente = explode(',', $miGrupo->dias ?? '');
                $diasComunes  = array_intersect($diasNuevo, $diasExistente);
 
                if (!empty($diasComunes)) {
                    $inicioNuevo = strtotime($grupo->hora_inicio);
                    $finNuevo    = strtotime($grupo->hora_fin);
                    $inicioEx    = strtotime($miGrupo->hora_inicio);
                    $finEx       = strtotime($miGrupo->hora_fin);
 
                    $hayTraslape = $inicioNuevo < $finEx && $finNuevo > $inicioEx;
 
                    if ($hayTraslape) {
                        return back()->with('error',
                            "Traslape de horario con \"{$miGrupo->materia->nombre} – {$miGrupo->nombre_grupo}\" ({$miGrupo->horario})."
                        );
                    }
                }
            }
        }

        $user->grupos()->attach($request->grupo_id);

        return redirect()->route('inscripciones.index')->with('success', "¡Inscripción exitosa a {$grupo->materia->nombre} – {$grupo->nombre_grupo}!");
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $user->grupos()->detach($id);

        return redirect()->route('inscripciones.index')->with('success', 'Te has dado de baja del grupo.');
    }
}
