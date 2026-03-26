<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Materias') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm border border-slate-200">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-purple-100 p-2.5 rounded-lg text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-700">Registrar Nueva Materia</h2>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 font-medium rounded-r-md">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('materias.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-5">
                    @csrf
                    
                    <div class="md:col-span-6">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Nombre de la Materia</label>
                        <input type="text" name="nombre" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500" placeholder="Ej. Inteligencia Artificial">
                    </div>
                    
                    <div class="md:col-span-3">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Clave (Libre)</label>
                        <input type="text" name="clave" required 
                               onkeyup="this.value = this.value.toUpperCase();"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500" 
                               placeholder="Ej. 2050">
                    </div>
                    
                    <div class="md:col-span-3">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Créditos</label>
                        <input type="number" name="creditos" required min="1" max="50" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500" placeholder="Ej. 8">
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Semestre Recomendado</label>
                        <select name="semestre" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Selecciona un semestre</option>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}º Semestre</option>
                            @endfor
                            <option value="Optativa">Optativa (Cualquiera)</option>
                        </select>
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Tipo de Materia</label>
                        <select name="tipo" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Selecciona el tipo</option>
                            <option value="Obligatoria">Obligatoria</option>
                            <option value="Optativa">Optativa</option>
                            <option value="Taller/Laboratorio">Taller / Laboratorio</option>
                            <option value="Extracurricular">Extracurricular</option>
                        </select>
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Área Académica</label>
                        <input type="text" name="area" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500" placeholder="Ej. Ciencias Básicas, Programación...">
                    </div>

                    <div class="md:col-span-12">
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Descripción / Temario (Opcional)</label>
                        <textarea name="descripcion" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500" placeholder="Breve descripción de lo que trata la materia..."></textarea>
                    </div>

                    <div class="md:col-span-12 flex justify-end mt-2">
                        <button type="submit" class="bg-purple-600 text-white font-bold px-8 py-3 rounded-lg hover:bg-purple-700 transition-all shadow-md flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Registrar Materia
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 tracking-wider">
                            <tr>
                                <th class="p-4 font-bold">Clave</th>
                                <th class="p-4 font-bold">Materia</th>
                                <th class="p-4 font-bold text-center">Semestre</th>
                                <th class="p-4 font-bold">Tipo / Área</th>
                                <th class="p-4 font-bold text-center">Créditos</th>
                                <th class="p-4 font-bold text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($materias as $materia)
                            <tr class="hover:bg-purple-50/30 transition-colors group">
                                <td class="p-4 text-sm font-mono font-bold text-purple-600">{{ $materia->clave }}</td>
                                <td class="p-4">
                                    <span class="block text-sm font-bold text-slate-700">{{ $materia->nombre }}</span>
                                    <span class="block text-xs text-slate-400 truncate max-w-[200px]">{{ $materia->descripcion ?: 'Sin descripción' }}</span>
                                </td>
                                <td class="p-4 text-sm text-center text-slate-600 font-medium">{{ $materia->semestre }}</td>
                                <td class="p-4">
                                    <span class="inline-flex px-2 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-md uppercase">{{ $materia->tipo }}</span>
                                    <span class="block text-xs text-slate-400 mt-1">{{ $materia->area }}</span>
                                </td>
                                <td class="p-4 text-sm text-center font-bold text-slate-700">{{ $materia->creditos }}</td>
                                <td class="p-4 text-sm">
                                    <div x-data="{ openModal: false }" class="flex justify-center gap-2 transition-opacity">
                                        
                                        <button @click="openModal = true" type="button" class="p-2 text-blue-500 hover:bg-blue-100 rounded-lg transition-colors" title="Editar Materia">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>

                                        <form action="{{ route('materias.destroy', $materia->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta materia?');">
                                            @csrf
                                            <button type="submit" class="p-2 text-red-500 hover:bg-red-100 rounded-lg transition-colors" title="Eliminar Materia">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>

                                        <div x-show="openModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900 bg-opacity-50 backdrop-blur-sm">
                                            <div @click.away="openModal = false" class="bg-white rounded-xl shadow-2xl w-full max-w-3xl p-8 max-h-[90vh] overflow-y-auto text-left relative">
                                                
                                                <h3 class="text-2xl font-bold text-slate-800 mb-6 border-b pb-4">Editar Materia: {{ $materia->clave }}</h3>
                                                <button @click="openModal = false" class="absolute top-6 right-6 text-slate-400 hover:text-red-500">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>

                                                <form action="{{ route('materias.update', $materia->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-5">
                                                    @csrf
                                                    @method('PUT') <div class="md:col-span-6">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Nombre de la Materia</label>
                                                        <input type="text" name="nombre" value="{{ $materia->nombre }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    </div>
                                                    <div class="md:col-span-3">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Clave</label>
                                                        <input type="text" name="clave" value="{{ $materia->clave }}" required onkeyup="this.value = this.value.toUpperCase();" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    </div>
                                                    <div class="md:col-span-3">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Créditos</label>
                                                        <input type="number" name="creditos" value="{{ $materia->creditos }}" required min="1" max="50" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    </div>
                                                    <div class="md:col-span-4">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Semestre</label>
                                                        <input type="text" name="semestre" value="{{ $materia->semestre }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    </div>
                                                    <div class="md:col-span-4">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Tipo</label>
                                                        <select name="tipo" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                            <option value="Obligatoria" {{ $materia->tipo == 'Obligatoria' ? 'selected' : '' }}>Obligatoria</option>
                                                            <option value="Optativa" {{ $materia->tipo == 'Optativa' ? 'selected' : '' }}>Optativa</option>
                                                            <option value="Taller/Laboratorio" {{ $materia->tipo == 'Taller/Laboratorio' ? 'selected' : '' }}>Taller / Laboratorio</option>
                                                            <option value="Extracurricular" {{ $materia->tipo == 'Extracurricular' ? 'selected' : '' }}>Extracurricular</option>
                                                        </select>
                                                    </div>
                                                    <div class="md:col-span-4">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Área Académica</label>
                                                        <input type="text" name="area" value="{{ $materia->area }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                                    </div>
                                                    <div class="md:col-span-12">
                                                        <label class="block text-sm font-semibold text-slate-600 mb-1">Descripción</label>
                                                        <textarea name="descripcion" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500">{{ $materia->descripcion }}</textarea>
                                                    </div>
                                                    <div class="md:col-span-12 flex justify-end gap-3 mt-4">
                                                        <button type="button" @click="openModal = false" class="bg-slate-200 text-slate-700 font-bold px-6 py-2 rounded-lg hover:bg-slate-300 transition-all">Cancelar</button>
                                                        <button type="submit" class="bg-purple-600 text-white font-bold px-6 py-2 rounded-lg hover:bg-purple-700 transition-all shadow-md">Actualizar Materia</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400">No hay materias en el catálogo. Comienza registrando una.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($materias->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $materias->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>