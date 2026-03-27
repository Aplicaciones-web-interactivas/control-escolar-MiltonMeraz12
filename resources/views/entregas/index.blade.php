<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mis Tareas</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm font-medium">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- ✅ Mostramos TODOS los grupos inscritos, tengan o no tareas --}}
            @forelse ($grupos as $grupo)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                    {{-- Encabezado del grupo — siempre visible --}}
                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-slate-700">{{ $grupo->materia->nombre }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $grupo->nombre_grupo }}</p>
                        </div>
                        <span class="text-xs text-slate-400 font-medium">
                            {{ $grupo->tareas->count() }} tarea(s)
                        </span>
                    </div>

                    {{-- Si el grupo tiene tareas, las mostramos --}}
                    @if($grupo->tareas->isNotEmpty())
                        <div class="divide-y divide-slate-100">
                            @foreach ($grupo->tareas as $tarea)
                                @php
                                    $entrega = $entregasDelAlumno[$tarea->id] ?? null;
                                    $vencida   = $tarea->vencida();
                                    $entregada = $entrega !== null;
                                @endphp

                                <div class="px-6 py-5">
                                    {{-- Título y estado --}}
                                    <div class="flex items-start justify-between gap-4 flex-wrap mb-3">
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">{{ $tarea->titulo }}</p>
                                            @if($tarea->descripcion)
                                                <p class="text-xs text-slate-500 mt-0.5">{{ $tarea->descripcion }}</p>
                                            @endif
                                            <p class="text-xs text-slate-400 mt-1">
                                                Límite: {{ $tarea->fecha_limite->format('d/m/Y H:i') }}
                                            </p>
                                        </div>

                                        {{-- Badge de estado --}}
                                        @if($entregada && $entrega->estado === 'revisado')
                                            <span class="px-2.5 py-1 text-xs font-bold bg-indigo-100 text-indigo-700 rounded-full shrink-0">Revisado</span>
                                        @elseif($entregada)
                                            <span class="px-2.5 py-1 text-xs font-bold bg-emerald-100 text-emerald-700 rounded-full shrink-0">Entregado</span>
                                        @elseif($vencida)
                                            <span class="px-2.5 py-1 text-xs font-bold bg-red-100 text-red-600 rounded-full shrink-0">Vencida</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-bold bg-amber-100 text-amber-700 rounded-full shrink-0">Pendiente</span>
                                        @endif
                                    </div>

                                    {{-- Ya entregó: mostrar info y comentario del profesor --}}
                                    @if($entregada)
                                        <div class="mt-2 p-3 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between gap-3 flex-wrap">
                                            <div>
                                                <p class="text-xs text-slate-500">
                                                    Entregado el {{ $entrega->created_at->format('d/m/Y H:i') }}
                                                </p>
                                                @if($entrega->comentario_profesor)
                                                    <p class="text-xs text-indigo-700 font-medium mt-1">
                                                        💬 Retroalimentación: {{ $entrega->comentario_profesor }}
                                                    </p>
                                                @else
                                                    <p class="text-xs text-slate-400 mt-1 italic">Sin comentarios del profesor aún.</p>
                                                @endif
                                            </div>
                                            <a href="{{ route('entregas.descargar', $entrega->id) }}"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors shrink-0">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                Ver mi entrega
                                            </a>
                                        </div>

                                    {{-- No entregó y tarea activa: formulario de subida --}}
                                    @elseif(!$vencida)
                                        <form action="{{ route('entregas.store', $tarea->id) }}" method="POST"
                                              enctype="multipart/form-data"
                                              class="mt-2 flex items-center gap-3 flex-wrap">
                                            @csrf
                                            <div class="flex-1 min-w-0">
                                                <input type="file" name="archivo" accept=".pdf" required
                                                       class="block w-full text-sm text-slate-500
                                                              file:mr-3 file:py-2 file:px-4
                                                              file:rounded-lg file:border-0
                                                              file:text-xs file:font-bold
                                                              file:bg-indigo-50 file:text-indigo-700
                                                              hover:file:bg-indigo-100 cursor-pointer">
                                                <p class="text-[10px] text-slate-400 mt-1">Solo PDF · Máximo 5 MB</p>
                                            </div>
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 active:scale-95 transition-all shrink-0">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                Entregar
                                            </button>
                                        </form>

                                    {{-- No entregó y ya venció --}}
                                    @else
                                        <p class="text-xs text-slate-400 mt-2 italic">No entregaste esta tarea antes del límite.</p>
                                    @endif

                                </div>
                            @endforeach
                        </div>

                    {{-- --}}
                    @else
                        <div class="px-6 py-8 text-center">
                            <p class="text-sm text-slate-400">Este grupo no tiene tareas asignadas aún.</p>
                        </div>
                    @endif

                </div>
            @empty
                {{-- El alumno no está inscrito en ningún grupo --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-slate-400 text-sm">No estás inscrito en ningún grupo todavía.</p>
                    <a href="{{ route('inscripciones.index') }}"
                       class="mt-3 inline-block text-sm text-indigo-600 hover:underline font-medium">
                        Inscribirme a grupos →
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>