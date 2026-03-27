<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mis Tareas</h2>
            <a href="{{ route('tareas.crear') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nueva Tarea
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @forelse ($grupos as $grupo)
                @if($grupo->tareas->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        {{-- Encabezado del grupo --}}
                        <div class="px-6 py-4 bg-slate-50 border-b border-slate-100">
                            <p class="text-sm font-bold text-slate-700">{{ $grupo->materia->nombre }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $grupo->nombre_grupo }} · {{ $grupo->horario }}</p>
                        </div>

                        <div class="divide-y divide-slate-100">
                            @foreach ($grupo->tareas as $tarea)
                                <div class="px-6 py-4 flex items-center justify-between gap-4 flex-wrap">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-slate-800 truncate">{{ $tarea->titulo }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            Límite: {{ $tarea->fecha_limite->format('d/m/Y H:i') }}
                                            @if($tarea->vencida())
                                                <span class="ml-2 px-2 py-0.5 bg-red-100 text-red-600 rounded-full text-[10px] font-bold">Vencida</span>
                                            @else
                                                <span class="ml-2 px-2 py-0.5 bg-emerald-100 text-emerald-600 rounded-full text-[10px] font-bold">Activa</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-3 shrink-0">
                                        {{-- Contador de entregas --}}
                                        <span class="text-xs text-slate-500 font-medium">
                                            {{ $tarea->entregas->count() }} / {{ $grupo->alumnos->count() }} entregas
                                        </span>
                                        {{-- Ver entregas --}}
                                        <a href="{{ route('tareas.revisar', $tarea->id) }}"
                                           class="px-3 py-1.5 text-xs font-bold text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                                            Revisar
                                        </a>
                                        {{-- Eliminar --}}
                                        <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar esta tarea? Se borrarán todas las entregas.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-slate-400 text-sm">No tienes tareas creadas aún.</p>
                    <a href="{{ route('tareas.crear') }}" class="mt-3 inline-block text-sm text-indigo-600 hover:underline font-medium">Crear primera tarea</a>
                </div>
            @endforelse

            {{-- Grupos sin tareas aún --}}
            @foreach ($grupos as $grupo)
                @if($grupo->tareas->isEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-dashed border-slate-200 px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">{{ $grupo->materia->nombre }} — {{ $grupo->nombre_grupo }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">Sin tareas asignadas</p>
                        </div>
                        <a href="{{ route('tareas.crear') }}?grupo={{ $grupo->id }}"
                           class="text-xs text-indigo-500 hover:underline font-medium">+ Crear tarea</a>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
</x-app-layout>