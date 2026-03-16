<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Cuenta - Control Escolar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900 bg-white">
    <div class="flex min-h-screen bg-white">
        
        <div class="hidden md:flex md:w-1/2 bg-blue-900 justify-center items-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                <svg class="absolute inset-0 h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none"><defs><pattern id="pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M0 40V0H40V40H0ZM20 20A20 20 0 1 0 20 60 20 20 0 1 0 20 20Z" fill="currentColor"></path></pattern></defs><rect width="100%" height="100%" fill="url(#pattern)"></rect></svg>
            </div>
            
            <div class="relative z-10 text-center px-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-800 text-white mb-6 shadow-xl">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h1 class="text-4xl font-black text-white mb-4 tracking-tight">Únete al Sistema</h1>
                <p class="text-blue-200 text-lg font-medium max-w-md mx-auto">Crea tu cuenta para empezar a dar de alta tus materias y armar tu horario.</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 overflow-y-auto">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center md:text-left">
                    <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Crear Cuenta</h2>
                    <p class="mt-2 text-sm text-slate-500">Completa tus datos para registrarte.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Nombre Completo</label>
                        <input id="name" type="text" name="name" required autofocus class="w-full border-slate-300 focus:border-blue-500 rounded-lg shadow-sm px-4 py-3" placeholder="Ej. Juan Pérez">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-700 mb-1">Correo Institucional</label>
                        <input id="email" type="email" name="email" required class="w-full border-slate-300 focus:border-blue-500 rounded-lg shadow-sm px-4 py-3" placeholder="ejemplo@uaslp.mx">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-1">Contraseña</label>
                        <input id="password" type="password" name="password" required class="w-full border-slate-300 focus:border-blue-500 rounded-lg shadow-sm px-4 py-3" placeholder="Mínimo 8 caracteres">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1">Confirmar Contraseña</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full border-slate-300 focus:border-blue-500 rounded-lg shadow-sm px-4 py-3">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition-all">
                            Registrarme
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm text-slate-500">
                    ¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-500 transition-colors">Inicia sesión aquí</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>