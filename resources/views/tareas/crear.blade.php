<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nueva Tarea</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/70">
                    <h3 class="text-base font-bold text-slate-800">Datos de la tarea</h3>
                    <p class="text-xs text-slate-500 mt-0.5">La tarea será visible para todos los alumnos del grupo seleccionado</p>
                </div>

                <form action="{{ route('tareas.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    {{-- Grupo --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Grupo</label>
                        <select name="grupo_id" required
                                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Selecciona un grupo</option>
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo->id }}"
                                    {{ (request('grupo') == $grupo->id || old('grupo_id') == $grupo->id) ? 'selected' : '' }}>
                                    {{ $grupo->materia->nombre }} — {{ $grupo->nombre_grupo }}
                                </option>
                            @endforeach
                        </select>
                        @error('grupo_id')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Título --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Título</label>
                        <input type="text" name="titulo" value="{{ old('titulo') }}" required
                               placeholder="Ej. Práctica 1 — Listas enlazadas"
                               class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('titulo')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Descripción / Instrucciones
                            <span class="font-normal text-slate-400">(opcional)</span>
                        </label>
                        <textarea name="descripcion" rows="4"
                                  placeholder="Describe qué deben entregar los alumnos..."
                                  class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fecha límite --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Fecha y hora límite</label>
                        <input type="datetime-local" name="fecha_limite" value="{{ old('fecha_limite') }}" required
                               class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('fecha_limite')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('tareas.index') }}"
                           class="text-sm text-slate-500 hover:text-slate-800 transition-colors">
                            ← Cancelar
                        </a>
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Publicar Tarea
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>