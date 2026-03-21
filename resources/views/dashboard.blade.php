<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control Escolar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ── Bienvenida ──────────────────────────────────────────────────── --}}
            <div class="bg-indigo-600 rounded-2xl p-8 text-white shadow-lg">
                <h1 class="text-3xl font-bold mb-1">¡Hola, {{ Auth::user()->name }}!</h1>
                <p class="text-indigo-200 text-sm">
                    Bienvenid@ al Sistema de Control Escolar ·
                    <span class="capitalize font-semibold text-white">{{ Auth::user()->rol }}</span>
                </p>
            </div>

            {{-- ── Tarjetas de estadísticas ─────────────────────────────────────── --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Materias en registro — visible para todos --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-5">
                    <div class="bg-purple-100 p-4 rounded-xl text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Materias en Registro</p>
                        <p class="text-3xl font-black text-slate-800 mt-1">{{ $materiasCount }}</p>
                    </div>
                </div>

                {{-- Grupos abiertos — visible para todos --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-5">
                    <div class="bg-emerald-100 p-4 rounded-xl text-emerald-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Grupos Abiertos</p>
                        <p class="text-3xl font-black text-slate-800 mt-1">{{ $gruposCount }}</p>
                    </div>
                </div>

                {{-- Tercera tarjeta — distinta según rol --}}
                @if(Auth::user()->esAlumno())
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-5">
                        <div class="bg-blue-100 p-4 rounded-xl text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Mis Inscripciones</p>
                            <p class="text-3xl font-black text-slate-800 mt-1">{{ $misInscripciones }}</p>
                        </div>
                    </div>

                @elseif(Auth::user()->esProfesor())
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-5">
                        <div class="bg-amber-100 p-4 rounded-xl text-amber-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Mis Grupos</p>
                            <p class="text-3xl font-black text-slate-800 mt-1">{{ $misGruposProfesor }}</p>
                        </div>
                    </div>

                @else {{-- Admin --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-5">
                        <div class="bg-rose-100 p-4 rounded-xl text-rose-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Total Usuarios</p>
                            <p class="text-3xl font-black text-slate-800 mt-1">{{ \App\Models\User::count() }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- ── Accesos rápidos según rol ────────────────────────────────────── --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- ALUMNO: Armar horario + Ver boleta --}}
                @if(Auth::user()->esAlumno())
                    <a href="{{ route('inscripciones.index') }}"
                       class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:border-blue-400 hover:shadow-md transition-all flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800 group-hover:text-blue-700">Armar mi Horario</h3>
                            <p class="text-sm text-slate-500 mt-0.5">Inscríbete a los grupos disponibles.</p>
                        </div>
                        <svg class="w-6 h-6 text-slate-300 group-hover:text-blue-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <a href="{{ route('calificaciones.boleta') }}"
                       class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:border-indigo-400 hover:shadow-md transition-all flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800 group-hover:text-indigo-700">Mi Boleta de Calificaciones</h3>
                            <p class="text-sm text-slate-500 mt-0.5">Consulta tus parciales y promedio final.</p>
                        </div>
                        <svg class="w-6 h-6 text-slate-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                {{-- PROFESOR: Sus grupos + Captura de calificaciones --}}
                @elseif(Auth::user()->esProfesor())
                    <a href="{{ route('calificaciones.grupos') }}"
                       class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:border-amber-400 hover:shadow-md transition-all flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800 group-hover:text-amber-700">Capturar Calificaciones</h3>
                            <p class="text-sm text-slate-500 mt-0.5">Registra los parciales de tus alumnos.</p>
                        </div>
                        <svg class="w-6 h-6 text-slate-300 group-hover:text-amber-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <a href="{{ route('grupos.index') }}"
                       class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:border-emerald-400 hover:shadow-md transition-all flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800 group-hover:text-emerald-700">Ver Grupos</h3>
                            <p class="text-sm text-slate-500 mt-0.5">Consulta los grupos del sistema.</p>
                        </div>
                        <svg class="w-6 h-6 text-slate-300 group-hover:text-emerald-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                {{-- ADMIN: Materias + Grupos --}}
                @else
                    <a href="{{ route('materias.index') }}"
                       class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:border-purple-400 hover:shadow-md transition-all flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800 group-hover:text-purple-700">Gestionar Materias</h3>
                            <p class="text-sm text-slate-500 mt-0.5">Crea, edita y elimina materias del catálogo.</p>
                        </div>
                        <svg class="w-6 h-6 text-slate-300 group-hover:text-purple-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <a href="{{ route('grupos.index') }}"
                       class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:border-emerald-400 hover:shadow-md transition-all flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800 group-hover:text-emerald-700">Gestionar Grupos</h3>
                            <p class="text-sm text-slate-500 mt-0.5">Abre y administra grupos con horarios.</p>
                        </div>
                        <svg class="w-6 h-6 text-slate-300 group-hover:text-emerald-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>