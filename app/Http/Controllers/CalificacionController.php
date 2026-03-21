<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calificacion;
use App\Models\Grupo;
use Illuminate\Support\Facades\Auth;


class CalificacionController extends Controller
{

    public function miBoleta()
    {
        $user = Auth::user();
 
        $calificaciones = Calificacion::with('grupo.materia')
            ->where('user_id', $user->id)
            ->get();
 
        return view('calificaciones.boleta', compact('calificaciones'));
    }

    public function misGrupos()
    {
        abort_if(!Auth::user()->esProfesor(), 403, 'Solo los profesores pueden acceder aquí.');

        $profesor = Auth::user();
 
        $grupos = Grupo::with(['materia', 'alumnos'])
            ->where('profesor_id', $profesor->id)
            ->get();
 
        return view('calificaciones.grupos', compact('grupos'));
    }
 
    public function capturar($grupoId)
    {
        abort_if(!Auth::user()->esProfesor(), 403, 'Solo los profesores pueden acceder aquí.');

        $profesor = Auth::user();
        $grupo    = Grupo::with(['materia', 'alumnos'])->findOrFail($grupoId);
 
        abort_if($grupo->profesor_id !== $profesor->id, 403, 'No tienes permiso para editar estas calificaciones.');
 
        $alumnos = $grupo->alumnos->map(function ($alumno) use ($grupoId) {
            $alumno->calificacion = Calificacion::firstOrNew([
                'user_id'  => $alumno->id,
                'grupo_id' => $grupoId,
            ]);
            return $alumno;
        });
 
        return view('calificaciones.capturar', compact('grupo', 'alumnos'));
    }
 
    public function guardar(Request $request, $grupoId)
    {
        abort_if(!Auth::user()->esProfesor(), 403);

        $profesor = Auth::user();
        $grupo    = Grupo::findOrFail($grupoId);
 
        abort_if($grupo->profesor_id !== $profesor->id, 403);
 
        $request->validate([
            'calificaciones'             => 'required|array',
            'calificaciones.*.user_id'   => 'required|exists:users,id',
            'calificaciones.*.parcial_1' => 'nullable|numeric|min:0|max:10',
            'calificaciones.*.parcial_2' => 'nullable|numeric|min:0|max:10',
            'calificaciones.*.parcial_3' => 'nullable|numeric|min:0|max:10',
        ]);
 
        foreach ($request->calificaciones as $data) {
            $cal = Calificacion::updateOrCreate(
                [
                    'user_id'  => $data['user_id'],
                    'grupo_id' => $grupoId,
                ],
                [
                    'parcial_1' => $data['parcial_1'] ?? null,
                    'parcial_2' => $data['parcial_2'] ?? null,
                    'parcial_3' => $data['parcial_3'] ?? null,
                ]
            );
 
            $cal->recalcularFinal();
        }
 
        return redirect()->route('calificaciones.capturar', $grupoId)
            ->with('success', 'Calificaciones guardadas correctamente.');
    }
}
