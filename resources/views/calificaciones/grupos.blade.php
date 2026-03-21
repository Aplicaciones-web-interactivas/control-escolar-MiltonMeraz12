<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Grupos — Captura de Calificaciones') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/70">
                    <h3 class="text-base font-bold text-slate-800">Selecciona un grupo para capturar calificaciones</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Solo aparecen los grupos asignados a ti</p>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($grupos as $grupo)
                        <a href="{{ route('calificaciones.capturar', $grupo->id) }}"
                           class="flex items-center justify-between px-6 py-5 hover:bg-blue-50/30 transition-colors group">
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $grupo->materia->nombre }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    {{ $grupo->nombre_grupo }}
                                    @if($grupo->horario) · {{ $grupo->horario }} @endif
                                    @if($grupo->salon) · {{ $grupo->salon }} @endif
                                </p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <p class="text-sm font-bold text-slate-700">{{ $grupo->alumnos->count() }}</p>
                                    <p class="text-xs text-slate-400">alumnos</p>
                                </div>
                                <svg class="w-5 h-5 text-slate-300 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <p class="text-slate-400 text-sm">No tienes grupos asignados.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>