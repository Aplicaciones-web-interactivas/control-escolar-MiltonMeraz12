<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscripcionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Obtenemos los grupos a los que el alumno YA está inscrito
        $misGrupos = $user->grupos()->with('materia')->get();
        
        // Obtenemos un arreglo con los IDs de los grupos en los que ya está inscrito
        $misGruposIds = $misGrupos->pluck('id')->toArray();

        // Obtenemos los grupos DISPONIBLES (a los que no está inscrito aún)
        $gruposDisponibles = Grupo::with('materia')
                                  ->whereNotIn('id', $misGruposIds)
                                  ->get();

        return view('inscripciones.index', compact('misGrupos', 'gruposDisponibles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id'
        ]);

        $user = Auth::user();
        
        // attach() inserta el registro en la tabla pivote 'grupo_user'
        $user->grupos()->attach($request->grupo_id);

        return redirect()->route('inscripciones.index')->with('success', '¡Inscripción exitosa!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        
        // detach() elimina el registro de la tabla pivote
        $user->grupos()->detach($id);

        return redirect()->route('inscripciones.index')->with('success', 'Te has dado de baja del grupo.');
    }
}
