<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Grupos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm border border-slate-200">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-emerald-100 p-2.5 rounded-lg text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-700">Abrir Nuevo Grupo</h2>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 font-medium rounded-r-md">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('grupos.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-5" {{ $materias->isEmpty() ? 'style="pointer-events: none; opacity: 0.5;"' : '' }}>
                    @csrf
                    
                    <div class="md:col-span-4">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Materia</label>
                        <select name="materia_id" id="materia_select" onchange="actualizarPrefijo()" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="" data-clave="">Selecciona una materia...</option>
                            @foreach($materias as $materia)
                                <option value="{{ $materia->id }}" data-clave="{{ $materia->clave }}">{{ $materia->clave }} - {{ $materia->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Profesor Asignado</label>
                        <select name="profesor_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Selecciona al profesor...</option>
                            @foreach($profesores as $profesor)
                                <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Identificador del Grupo</label>
                        <div class="flex shadow-sm rounded-lg">
                            <span id="prefijo_visual" class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-slate-100 text-slate-600 font-bold sm:text-sm">
                                Clave
                            </span>
                            <input type="text" id="sufijo_input" oninput="actualizarValorFinal()" disabled required class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 disabled:bg-slate-50 disabled:text-slate-400" placeholder="Ej. A, 01...">
                        </div>
                        <input type="hidden" name="nombre_grupo" id="nombre_grupo_hidden">
                    </div>

                    <div class="md:col-span-12 bg-slate-50 p-5 rounded-lg border border-slate-200 mt-2">
                        <label class="block text-sm font-bold text-slate-700 mb-3">Días en los que se imparte la clase</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                            <label class="inline-flex items-center cursor-pointer hover:bg-emerald-100/50 p-2 rounded transition-colors">
                                <input type="checkbox" name="dias[]" value="{{ $dia }}" class="w-5 h-5 rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm font-medium text-slate-700">{{ $dia }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Entrada</label>
                        <input type="time" name="hora_inicio" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Salida</label>
                        <input type="time" name="hora_fin" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Modalidad</label>
                        <select name="modalidad" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="Presencial">Presencial</option>
                            <option value="En Línea">En Línea (Virtual)</option>
                            <option value="Híbrido">Híbrido</option>
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Salón / Plataforma</label>
                        <input type="text" name="salon" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" placeholder="Ej. Lab 3, Microsoft Teams...">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Cupo Máximo</label>
                        <input type="number" name="cupo" required min="1" value="30" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" placeholder="Ej. 30">
                    </div>

                    <div class="md:col-span-12 flex justify-end mt-4">
                        <button type="submit" class="bg-emerald-600 text-white font-bold px-8 py-3 rounded-lg hover:bg-emerald-700 transition-all shadow-md flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Registrar Grupo
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 tracking-wider">
                            <tr>
                                <th class="p-4 font-bold">Materia y Grupo</th>
                                <th class="p-4 font-bold">Profesor</th>
                                <th class="p-4 font-bold">Horario y Días</th>
                                <th class="p-4 font-bold text-center">Modalidad / Lugar</th>
                                <th class="p-4 font-bold text-center">Cupo</th>
                                <th class="p-4 font-bold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($grupos as $grupo)
                            <tr class="hover:bg-emerald-50/30 transition-colors group">
                                <td class="p-4">
                                    <span class="block text-sm font-bold text-emerald-600">{{ $grupo->materia->clave }}</span>
                                    <span class="block text-sm font-bold text-slate-700">{{ $grupo->materia->nombre }}</span>
                                    <span class="block text-xs text-slate-500 mt-1">Grupo: {{ $grupo->nombre_grupo }}</span>
                                </td>
                                <td class="p-4">
                                    <span class="text-sm font-semibold text-slate-700">{{ $grupo->profesor->name ?? 'Sin asignar' }}</span>
                                </td>
                                <td class="p-4 text-sm text-slate-600">
                                    <span class="font-semibold">{{ $grupo->horario }}</span>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex px-2 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-md uppercase">{{ $grupo->modalidad }}</span>
                                    <span class="block text-xs text-slate-500 mt-1 font-medium">{{ $grupo->salon ?: 'N/A' }}</span>
                                </td>
                                <td class="p-4 text-sm text-center font-bold text-slate-700">
                                    {{ $grupo->cupo }}
                                </td>
                                <td class="p-4 text-sm">
                                    <div x-data="{ openModalEdit: false }" class="flex justify-center gap-2 transition-opacity">
                                        
                                        <button @click="openModalEdit = true" type="button" class="p-2 text-blue-500 hover:bg-blue-100 rounded-lg transition-colors" title="Editar Grupo">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>

                                        <form action="{{ route('grupos.destroy', $grupo->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este grupo?');">
                                            @csrf
                                            <button type="submit" class="p-2 text-red-500 hover:bg-red-100 rounded-lg transition-colors" title="Eliminar Grupo">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>

                                        <div x-show="openModalEdit" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900 bg-opacity-50 backdrop-blur-sm">
                                            <div @click.away="openModalEdit = false" class="bg-white rounded-xl shadow-2xl w-full max-w-3xl p-8 max-h-[90vh] overflow-y-auto text-left relative">
                                                
                                                <h3 class="text-2xl font-bold text-slate-800 mb-6 border-b pb-4">Editar Grupo</h3>
                                                <button @click="openModalEdit = false" class="absolute top-6 right-6 text-slate-400 hover:text-red-500">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>

                                                <form action="{{ route('grupos.update', $grupo->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-5">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <div class="md:col-span-6">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Materia</label>
                                                        <select name="materia_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                                                            @foreach($materias as $materia)
                                                                <option value="{{ $materia->id }}" {{ $grupo->materia_id == $materia->id ? 'selected' : '' }}>{{ $materia->clave }} - {{ $materia->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="md:col-span-6">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Profesor Asignado</label>
                                                        <select name="profesor_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                                                            @foreach($profesores as $profesor)
                                                                <option value="{{ $profesor->id }}" {{ $grupo->profesor_id == $profesor->id ? 'selected' : '' }}>{{ $profesor->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="md:col-span-12">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Identificador del Grupo</label>
                                                        <input type="text" name="nombre_grupo" value="{{ $grupo->nombre_grupo }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                                                    </div>

                                                    <div class="md:col-span-12 bg-slate-50 p-4 rounded-lg">
                                                        <label class="block text-sm font-bold text-slate-700 mb-2">Re-seleccionar Días ({{ $grupo->horario }})</label>
                                                        <div class="flex flex-wrap gap-4">
                                                            @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input type="checkbox" name="dias[]" value="{{ $dia }}" class="w-5 h-5 rounded border-gray-300 text-emerald-600">
                                                                <span class="ml-2 text-sm font-medium">{{ $dia }}</span>
                                                            </label>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <div class="md:col-span-3">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Entrada</label>
                                                        <input type="time" name="hora_inicio" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                                                    </div>
                                                    <div class="md:col-span-3">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Salida</label>
                                                        <input type="time" name="hora_fin" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                                                    </div>
                                                    <div class="md:col-span-3">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Modalidad</label>
                                                        <select name="modalidad" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                                                            <option value="Presencial" {{ $grupo->modalidad == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                                                            <option value="En Línea" {{ $grupo->modalidad == 'En Línea' ? 'selected' : '' }}>En Línea</option>
                                                            <option value="Híbrido" {{ $grupo->modalidad == 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                                                        </select>
                                                    </div>
                                                    <div class="md:col-span-3">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Cupo</label>
                                                        <input type="number" name="cupo" value="{{ $grupo->cupo }}" required min="1" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                                                    </div>

                                                    <div class="md:col-span-12 flex justify-end gap-3 mt-4">
                                                        <button type="button" @click="openModalEdit = false" class="bg-slate-200 text-slate-700 font-bold px-6 py-2 rounded-lg hover:bg-slate-300 transition-all">Cancelar</button>
                                                        <button type="submit" class="bg-emerald-600 text-white font-bold px-6 py-2 rounded-lg hover:bg-emerald-700 transition-all shadow-md">Actualizar Grupo</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400">No hay grupos abiertos. Configura uno para comenzar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($grupos->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $grupos->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>
        // Nueva lógica más segura para el Addon Visual
        function actualizarPrefijo() {
            const select = document.getElementById('materia_select');
            const clave = select.options[select.selectedIndex].getAttribute('data-clave');
            const prefijoVisual = document.getElementById('prefijo_visual');
            const sufijoInput = document.getElementById('sufijo_input');
            
            if (clave) {
                // Escribe la clave en el cuadro gris inborrable
                prefijoVisual.textContent = clave + " - ";
                sufijoInput.disabled = false; // Habilita la escritura
            } else {
                prefijoVisual.textContent = "Clave";
                sufijoInput.disabled = true; // Deshabilita si no hay materia
                sufijoInput.value = "";
            }
            actualizarValorFinal();
        }

        function actualizarValorFinal() {
            const prefijo = document.getElementById('prefijo_visual').textContent.trim();
            const sufijo = document.getElementById('sufijo_input').value.trim();
            const hidden = document.getElementById('nombre_grupo_hidden');
            
            // Junta ambas partes (Ej. "ISI-101 - A") y las pone en el input oculto para enviarlas
            if (prefijo !== "Clave" && sufijo !== "") {
                hidden.value = prefijo + " " + sufijo;
            } else {
                hidden.value = "";
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            actualizarPrefijo();
        });
    </script>
</x-app-layout>