<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Captura de Calificaciones — {{ $grupo->materia->nombre }} ({{ $grupo->nombre_grupo }})
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/70 flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Lista de alumnos</h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ $alumnos->count() }} alumno(s) · Calificación final = promedio de parciales capturados
                        </p>
                    </div>
                    <a href="{{ route('calificaciones.grupos') }}"
                       class="text-sm text-slate-500 hover:text-slate-800 transition-colors">
                        ← Mis grupos
                    </a>
                </div>

                <form action="{{ route('calificaciones.guardar', $grupo->id) }}" method="POST">
                    @csrf
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="text-xs uppercase text-slate-500 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Alumno</th>
                                    <th class="px-6 py-3 font-semibold text-center w-32">Parcial 1</th>
                                    <th class="px-6 py-3 font-semibold text-center w-32">Parcial 2</th>
                                    <th class="px-6 py-3 font-semibold text-center w-32">Parcial 3</th>
                                    <th class="px-6 py-3 font-semibold text-center w-28">Final</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50" id="tabla-alumnos">
                                @forelse ($alumnos as $i => $alumno)
                                    @php $cal = $alumno->calificacion; @endphp
                                    <tr class="hover:bg-slate-50/40 transition-colors" data-row="{{ $i }}">
                                        <input type="hidden" name="calificaciones[{{ $i }}][user_id]" value="{{ $alumno->id }}">

                                        <td class="px-6 py-3">
                                            <p class="text-sm font-semibold text-slate-800">{{ $alumno->name }}</p>
                                            <p class="text-xs text-slate-400">{{ $alumno->email }}</p>
                                        </td>

                                        @foreach(['parcial_1','parcial_2','parcial_3'] as $p)
                                        <td class="px-4 py-3 text-center">
                                            <input type="number"
                                                   name="calificaciones[{{ $i }}][{{ $p }}]"
                                                   value="{{ old("calificaciones.$i.$p", $cal->$p) }}"
                                                   min="0" max="10" step="0.1"
                                                   placeholder="—"
                                                   data-parcial="{{ $i }}"
                                                   class="w-24 text-center text-sm border border-slate-200 rounded-lg px-2 py-1.5
                                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                          transition-colors parcial-input">
                                        </td>
                                        @endforeach

                                        <td class="px-4 py-3 text-center">
                                            <span id="final-{{ $i }}"
                                                  class="text-sm font-black
                                                    {{ !is_null($cal->final) && $cal->final >= 6 ? 'text-emerald-600' : (!is_null($cal->final) ? 'text-red-500' : 'text-slate-300') }}">
                                                {{ !is_null($cal->final) ? number_format($cal->final, 1) : '—' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 text-sm">
                                            No hay alumnos inscritos en este grupo.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($alumnos->isNotEmpty())
                        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Guardar calificaciones
                            </button>
                        </div>
                    @endif
                </form>
            </div>

        </div>
    </div>

    {{-- Vista previa del promedio mientras se escribe --}}
    <script>
    document.querySelectorAll('.parcial-input').forEach(input => {
        input.addEventListener('input', () => {
            const row = input.dataset.parcial;
            const inputs = document.querySelectorAll(`[data-parcial="${row}"]`);
            const vals = [...inputs].map(i => parseFloat(i.value)).filter(v => !isNaN(v));
            const span = document.getElementById(`final-${row}`);
            if (vals.length > 0) {
                const avg = (vals.reduce((a, b) => a + b, 0) / vals.length).toFixed(1);
                span.textContent = avg;
                span.className = 'text-sm font-black ' + (parseFloat(avg) >= 6 ? 'text-emerald-600' : 'text-red-500');
            } else {
                span.textContent = '—';
                span.className = 'text-sm font-black text-slate-300';
            }
        });
    });
    </script>
</x-app-layout>