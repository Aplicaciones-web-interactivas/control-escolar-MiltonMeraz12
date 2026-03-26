<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inscripción de Grupos') }}
        </h2>
    </x-slot>
 
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
 
            @if(session('success'))
                <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">
                    <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm font-medium">
                    <svg class="w-5 h-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif
 
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
 
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/70">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Grupos Disponibles</h3>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $gruposDisponibles->total() }} grupo(s) encontrado(s)</p>
                        </div>
                        <form method="GET" action="{{ route('inscripciones.index') }}"
                              class="flex flex-wrap gap-2 items-center">
                            {{-- Buscador --}}
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input type="text" name="buscar" value="{{ request('buscar') }}"
                                       placeholder="Buscar materia..."
                                       class="pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-48">
                            </div>
                            <select name="semestre"
                                    class="min-w-[120px] text-sm border border-slate-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-600">
                                <option value="">Semestre</option>
                                @foreach($semestres as $s)
                                    <option value="{{ $s }}" @selected(request('semestre') == $s)>{{ $s }}°</option>
                                @endforeach
                            </select>
                            <select name="area"
                                    class="min-w-[120px] text-sm border border-slate-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-600">
                                <option value="">Área</option>
                                @foreach($areas as $a)
                                    <option value="{{ $a }}" @selected(request('area') == $a)>{{ $a }}</option>
                                @endforeach
                            </select>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                Filtrar
                            </button>
                            @if(request()->hasAny(['buscar','semestre','area']))
                                <a href="{{ route('inscripciones.index') }}"
                                   class="px-3 py-2 text-sm text-slate-500 hover:text-slate-800 transition-colors">
                                    Limpiar
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
 
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="text-xs uppercase text-slate-500 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Materia</th>
                                <th class="px-6 py-3 font-semibold">Grupo</th>
                                <th class="px-6 py-3 font-semibold">Horario</th>
                                <th class="px-6 py-3 font-semibold">Salón</th>
                                <th class="px-6 py-3 font-semibold">Cupo</th>
                                <th class="px-6 py-3 font-semibold text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($gruposDisponibles as $grupo)
                                @php
                                    $inscritos  = $grupo->alumnos->count();
                                    $cupo       = $grupo->cupo ?? 0;
                                    $disponible = max(0, $cupo - $inscritos);
                                    $pct        = $cupo > 0 ? (int)(($inscritos / $cupo) * 100) : 0;
                                    $lleno      = $disponible === 0;
                                @endphp
                                <tr class="{{ $lleno ? 'bg-slate-50/50 opacity-60' : 'hover:bg-blue-50/30' }} transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-slate-800">{{ $grupo->materia->nombre }}</p>
                                        @if($grupo->materia->semestre)
                                            <p class="text-xs text-slate-400 mt-0.5">{{ $grupo->materia->semestre }}° semestre</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $grupo->nombre_grupo }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $grupo->horario }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-500">{{ $grupo->salon ?: '—' }}</td>
                                    <td class="px-6 py-4">
                                        @if($cupo > 0)
                                            <div class="w-28">
                                                <div class="flex justify-between text-xs mb-1">
                                                    <span class="{{ $lleno ? 'text-red-600 font-semibold' : 'text-slate-500' }}">
                                                        {{ $lleno ? 'Sin cupo' : "$disponible disponibles" }}
                                                    </span>
                                                    <span class="text-slate-400">{{ $inscritos }}/{{ $cupo }}</span>
                                                </div>
                                                <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="h-full rounded-full transition-all
                                                        {{ $pct >= 100 ? 'bg-red-400' : ($pct >= 75 ? 'bg-amber-400' : 'bg-emerald-400') }}"
                                                         style="width: {{ $pct }}%"></div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400">Sin límite</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($lleno)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-500 bg-red-50 rounded-lg">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                                Grupo lleno
                                            </span>
                                        @else
                                            <form action="{{ route('inscripciones.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 active:scale-95 transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                    Inscribirme
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <p class="text-slate-400 text-sm">No hay grupos disponibles con esos criterios.</p>
                                        @if(request()->hasAny(['buscar','semestre','area']))
                                            <a href="{{ route('inscripciones.index') }}" class="text-blue-500 text-sm hover:underline mt-1 inline-block">Limpiar filtros</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($gruposDisponibles->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $gruposDisponibles->links() }}
                    </div>
                @endif
                
            </div>
 
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/70 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Mi Horario Actual</h3>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $misGrupos->count() }} materia(s) inscrita(s)</p>
                    </div>
                    @if($misGrupos->isNotEmpty())
                        <a href="{{ route('calificaciones.boleta') }}"
                           class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Ver mi boleta
                        </a>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="text-xs uppercase text-slate-500 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Materia</th>
                                <th class="px-6 py-3 font-semibold">Grupo</th>
                                <th class="px-6 py-3 font-semibold">Horario</th>
                                <th class="px-6 py-3 font-semibold">Salón</th>
                                <th class="px-6 py-3 font-semibold text-center">Calificación</th>
                                <th class="px-6 py-3 font-semibold text-center">Baja</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($misGrupos as $miGrupo)
                                @php
                                    $cal    = $miGrupo->calificaciones->first();
                                    $final  = $cal?->final;
                                    $estado = $cal?->estado() ?? 'pendiente';
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-slate-800">{{ $miGrupo->materia->nombre }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $miGrupo->nombre_grupo }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $miGrupo->horario }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-500">{{ $miGrupo->salon ?: '—' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($estado === 'pendiente')
                                            <span class="inline-block px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-500 rounded-full">Pendiente</span>
                                        @elseif($estado === 'aprobado')
                                            <span class="inline-block px-2.5 py-1 text-xs font-bold bg-emerald-100 text-emerald-700 rounded-full">{{ number_format($final, 1) }} ✓</span>
                                        @else
                                            <span class="inline-block px-2.5 py-1 text-xs font-bold bg-red-100 text-red-600 rounded-full">{{ number_format($final, 1) }} ✗</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('inscripciones.destroy', $miGrupo->id) }}" method="POST"
                                              onsubmit="return confirm('¿Seguro que deseas darte de baja de {{ addslashes($miGrupo->materia->nombre) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                    title="Darse de baja">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        <p class="text-slate-400 text-sm">Aún no estás inscrito en ninguna materia.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
 
        </div>
    </div>
</x-app-layout>