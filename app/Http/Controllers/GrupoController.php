<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Materia;
use App\Models\User; // <-- IMPORTANTE AÑADIR ESTO PARA TRAER A LOS PROFESORES
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        // Traemos los grupos con su materia y su profesor asociado
        $grupos = Grupo::with(['materia', 'profesor'])->get();
        $materias = Materia::all();
        
        // Traemos todos los usuarios (Por ahora todos, después filtraremos por rol profesor)
        $profesores = User::all();
        
        return view('grupos.index', compact('grupos', 'materias', 'profesores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'profesor_id' => 'required|exists:users,id', // Validamos al profesor
            'nombre_grupo' => 'required|string|max:50',
            'dias' => 'required|array', // Es un array porque son checkboxes
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'modalidad' => 'required|string',
            'cupo' => 'required|integer|min:1',
            'salon' => 'nullable|string|max:100'
        ]);

        // Juntamos el arreglo de días en un solo string: Ej. "Lunes, Miércoles"
        $diasString = implode(', ', $request->dias);
        $horarioArmado = $diasString . ' (' . $request->hora_inicio . ' a ' . $request->hora_fin . ')';

        Grupo::create([
            'materia_id' => $request->materia_id,
            'profesor_id' => $request->profesor_id, // Guardamos el ID del profe
            'nombre_grupo' => $request->nombre_grupo,
            'horario' => $horarioArmado,
            'modalidad' => $request->modalidad,
            'cupo' => $request->cupo,
            'salon' => $request->salon
        ]);

        return redirect()->route('grupos.index')->with('success', 'Grupo registrado con éxito.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'profesor_id' => 'required|exists:users,id',
            'nombre_grupo' => 'required|string|max:50',
            'dias' => 'required|array',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'modalidad' => 'required|string',
            'cupo' => 'required|integer|min:1',
            'salon' => 'nullable|string|max:100'
        ]);

        $diasString = implode(', ', $request->dias);
        $horarioArmado = $diasString . ' (' . $request->hora_inicio . ' a ' . $request->hora_fin . ')';

        $grupo = Grupo::findOrFail($id);
        $grupo->update([
            'materia_id' => $request->materia_id,
            'profesor_id' => $request->profesor_id,
            'nombre_grupo' => $request->nombre_grupo,
            'horario' => $horarioArmado,
            'modalidad' => $request->modalidad,
            'cupo' => $request->cupo,
            'salon' => $request->salon
        ]);

        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado con éxito.');
    }

    public function destroy($id)
    {
        Grupo::findOrFail($id)->delete();
        return redirect()->route('grupos.index')->with('success', 'Grupo eliminado.');
    }
}