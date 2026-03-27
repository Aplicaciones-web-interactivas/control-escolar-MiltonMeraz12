<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-2">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $tarea->titulo }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $tarea->grupo->materia->nombre }} — {{ $tarea->grupo->nombre_grupo }}</p>
            </div>
            <a href="{{ route('tareas.index') }}" class="text-sm text-slate-500 hover:text-slate-800 transition-colors">← Mis tareas</a>
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

            {{-- Info de la tarea --}}
            <div class="bg-white rounded-2xl border border-slate-200 px-6 py-5 shadow-sm">
                <div class="flex flex-wrap gap-6">
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-semibold tracking-wide">Fecha límite</p>
                        <p class="text-sm font-bold text-slate-700 mt-0.5">
                            {{ $tarea->fecha_limite->format('d/m/Y H:i') }}
                            @if($tarea->vencida())
                                <span class="ml-2 px-2 py-0.5 bg-red-100 text-red-600 rounded-full text-[10px]">Vencida</span>
                            @else
                                <span class="ml-2 px-2 py-0.5 bg-emerald-100 text-emerald-600 rounded-full text-[10px]">Activa</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-semibold tracking-wide">Entregas</p>
                        <p class="text-sm font-bold text-slate-700 mt-0.5">
                            {{ $tarea->entregas->count() }} de {{ $tarea->grupo->alumnos->count() }} alumnos
                        </p>
                    </div>
                    @if($tarea->descripcion)
                    <div class="w-full">
                        <p class="text-xs text-slate-400 uppercase font-semibold tracking-wide">Instrucciones</p>
                        <p class="text-sm text-slate-600 mt-0.5">{{ $tarea->descripcion }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Lista de alumnos y su estado de entrega --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70">
                    <h3 class="text-sm font-bold text-slate-700">Alumnos del grupo</h3>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($tarea->grupo->alumnos as $alumno)
                        @php
                            $entrega = $tarea->entregas->firstWhere('alumno_id', $alumno->id);
                        @endphp
                        <div class="px-6 py-4">
                            <div class="flex items-start justify-between gap-4 flex-wrap">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $alumno->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $alumno->email }}</p>
                                </div>

                                @if($entrega)
                                    <div class="flex items-center gap-3">
                                        {{-- Estado --}}
                                        @if($entrega->estado === 'revisado')
                                            <span class="px-2.5 py-1 text-xs font-bold bg-indigo-100 text-indigo-700 rounded-full">Revisado</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-bold bg-amber-100 text-amber-700 rounded-full">Entregado</span>
                                        @endif
                                        {{-- Fecha entrega --}}
                                        <span class="text-xs text-slate-400">{{ $entrega->created_at->format('d/m/Y H:i') }}</span>
                                        {{-- Descargar PDF --}}
                                        <a href="{{ route('entregas.descargar', $entrega->id) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            Descargar PDF
                                        </a>
                                    </div>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-400 rounded-full">Sin entrega</span>
                                @endif
                            </div>

                            {{-- Formulario de comentario (solo si hay entrega) --}}
                            @if($entrega)
                                <form action="{{ route('tareas.comentar', $entrega->id) }}" method="POST"
                                      class="mt-3 flex gap-2 items-end">
                                    @csrf
                                    <div class="flex-1">
                                        <label class="text-xs text-slate-400 font-medium block mb-1">Comentario al alumno</label>
                                        <textarea name="comentario_profesor" rows="2"
                                                  placeholder="Escribe retroalimentación opcional..."
                                                  class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none">{{ $entrega->comentario_profesor }}</textarea>
                                    </div>
                                    <button type="submit"
                                            class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors shrink-0">
                                        Guardar
                                    </button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-slate-400 text-sm">No hay alumnos en este grupo.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>