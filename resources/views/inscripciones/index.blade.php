<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inscripción de Grupos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 font-medium rounded-r-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold mb-4 text-slate-700">Grupos Disponibles</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                            <tr>
                                <th class="p-4 font-bold">Materia</th>
                                <th class="p-4 font-bold">Grupo</th>
                                <th class="p-4 font-bold">Horario</th>
                                <th class="p-4 font-bold text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($gruposDisponibles as $grupo)
                            <tr class="hover:bg-blue-50/30">
                                <td class="p-4 text-sm font-bold text-slate-700">{{ $grupo->materia->nombre }}</td>
                                <td class="p-4 text-sm text-slate-600">{{ $grupo->nombre_grupo }}</td>
                                <td class="p-4 text-sm text-slate-600">{{ $grupo->horario }}</td>
                                <td class="p-4 text-sm flex justify-center">
                                    <form action="{{ route('inscripciones.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-xs font-bold transition-colors">
                                            Inscribirme
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-slate-400">No hay grupos nuevos disponibles.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold mb-4 text-slate-700">Mi Horario Actual</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                            <tr>
                                <th class="p-4 font-bold">Materia</th>
                                <th class="p-4 font-bold">Grupo</th>
                                <th class="p-4 font-bold">Horario</th>
                                <th class="p-4 font-bold">Salón</th>
                                <th class="p-4 font-bold text-center">Baja</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($misGrupos as $miGrupo)
                            <tr class="hover:bg-red-50/30 transition-colors">
                                <td class="p-4 text-sm font-bold text-slate-700">{{ $miGrupo->materia->nombre }}</td>
                                <td class="p-4 text-sm text-slate-600">{{ $miGrupo->nombre_grupo }}</td>
                                <td class="p-4 text-sm text-slate-600">{{ $miGrupo->horario }}</td>
                                <td class="p-4 text-sm text-slate-500">{{ $miGrupo->salon ?: 'N/A' }}</td>
                                <td class="p-4 text-sm flex justify-center">
                                    <form action="{{ route('inscripciones.destroy', $miGrupo->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas darte de baja de esta materia?');">
                                        @csrf
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-100 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400">Aún no te has inscrito a ninguna materia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>