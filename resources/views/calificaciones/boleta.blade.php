<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Boleta de Calificaciones') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Resumen rápido --}}
            @php
                $aprobadas  = $calificaciones->filter(fn($c) => $c->estado() === 'aprobado')->count();
                $reprobadas = $calificaciones->filter(fn($c) => $c->estado() === 'reprobado')->count();
                $pendientes = $calificaciones->filter(fn($c) => $c->estado() === 'pendiente')->count();
                $promedio   = $calificaciones->whereNotNull('final')->avg('final');
            @endphp

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 text-center shadow-sm">
                    <p class="text-3xl font-black text-slate-800">{{ $calificaciones->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1 font-medium uppercase tracking-wide">Materias</p>
                </div>
                <div class="bg-white rounded-2xl border border-emerald-200 p-5 text-center shadow-sm">
                    <p class="text-3xl font-black text-emerald-600">{{ $aprobadas }}</p>
                    <p class="text-xs text-emerald-500 mt-1 font-medium uppercase tracking-wide">Aprobadas</p>
                </div>
                <div class="bg-white rounded-2xl border border-red-200 p-5 text-center shadow-sm">
                    <p class="text-3xl font-black text-red-500">{{ $reprobadas }}</p>
                    <p class="text-xs text-red-400 mt-1 font-medium uppercase tracking-wide">Reprobadas</p>
                </div>
                <div class="bg-white rounded-2xl border border-indigo-200 p-5 text-center shadow-sm">
                    <p class="text-3xl font-black text-indigo-600">{{ $promedio ? number_format($promedio, 1) : '—' }}</p>
                    <p class="text-xs text-indigo-400 mt-1 font-medium uppercase tracking-wide">Promedio general</p>
                </div>
            </div>

            {{-- Tabla de calificaciones --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/70">
                    <h3 class="text-base font-bold text-slate-800">Detalle por materia</h3>
                    <p class="text-xs text-slate-500 mt-0.5">La calificación final es el promedio de los parciales capturados</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="text-xs uppercase text-slate-500 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Materia</th>
                                <th class="px-6 py-3 font-semibold">Grupo</th>
                                <th class="px-6 py-3 font-semibold text-center">Parcial 1</th>
                                <th class="px-6 py-3 font-semibold text-center">Parcial 2</th>
                                <th class="px-6 py-3 font-semibold text-center">Parcial 3</th>
                                <th class="px-6 py-3 font-semibold text-center">Final</th>
                                <th class="px-6 py-3 font-semibold text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($calificaciones as $cal)
                                @php $estado = $cal->estado(); @endphp
                                <tr class="hover:bg-slate-50/40 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-slate-800">{{ $cal->grupo->materia->nombre }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500">{{ $cal->grupo->nombre_grupo }}</td>

                                    @foreach(['parcial_1', 'parcial_2', 'parcial_3'] as $p)
                                        <td class="px-6 py-4 text-center">
                                            @if(!is_null($cal->$p))
                                                <span class="text-sm font-semibold
                                                    {{ $cal->$p >= 70 ? 'text-emerald-600' : 'text-red-500' }}">
                                                    {{ number_format($cal->$p, 1) }}
                                                </span>
                                            @else
                                                <span class="text-slate-300 text-sm">—</span>
                                            @endif
                                        </td>
                                    @endforeach

                                    <td class="px-6 py-4 text-center">
                                        @if(!is_null($cal->final))
                                            <span class="text-base font-black
                                                {{ $cal->final >= 70 ? 'text-emerald-600' : 'text-red-600' }}">
                                                {{ number_format($cal->final, 1) }}
                                            </span>
                                        @else
                                            <span class="text-slate-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($estado === 'pendiente')
                                            <span class="inline-block px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-500 rounded-full">Pendiente</span>
                                        @elseif($estado === 'aprobado')
                                            <span class="inline-block px-2.5 py-1 text-xs font-bold bg-emerald-100 text-emerald-700 rounded-full">Aprobado</span>
                                        @else
                                            <span class="inline-block px-2.5 py-1 text-xs font-bold bg-red-100 text-red-600 rounded-full">Reprobado</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <p class="text-slate-400 text-sm">No tienes calificaciones registradas aún.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-center mt-6">
                <a href="{{ route('inscripciones.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm group">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Volver a mi horario
                </a>
            </div>
        </div>
    </div>
</x-app-layout>