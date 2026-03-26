<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::paginate(5);
        return view('materias.index', compact('materias'));
    }

    public function store(Request $request)
    {
        // 1. Guardamos la validación en una variable
        $datosValidados = $request->validate([
            'nombre' => 'required|string|max:255',
            'clave' => 'required|string|unique:materias',
            'creditos' => 'required|integer|min:1',
            'semestre' => 'required|string',
            'tipo' => 'required|string',
            'area' => 'required|string|max:100',
            'descripcion' => 'nullable|string'
        ]);

        // 2. Le pasamos SOLO los datos validados (esto ignora el _token automáticamente)
        Materia::create($datosValidados);

        return redirect()->route('materias.index')->with('success', 'Materia registrada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $datosValidados = $request->validate([
            'nombre' => 'required|string|max:255',
            'clave' => 'required|string|unique:materias,clave,'.$id, // Ignora la clave actual en la regla unique
            'creditos' => 'required|integer|min:1',
            'semestre' => 'required|string',
            'tipo' => 'required|string',
            'area' => 'required|string|max:100',
            'descripcion' => 'nullable|string'
        ]);

        $materia = Materia::findOrFail($id);
        $materia->update($datosValidados);

        return redirect()->route('materias.index')->with('success', 'Materia actualizada correctamente.');
    }

    public function destroy($id)
    {
        Materia::findOrFail($id)->delete();
        return redirect()->route('materias.index')->with('success', 'Materia eliminada.');
    }
}
