<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - Control Escolar</title>
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
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v6.5"></path></svg>
                </div>
                <h1 class="text-4xl font-black text-white mb-4 tracking-tight">Control Escolar</h1>
                <p class="text-blue-200 text-lg font-medium max-w-md mx-auto">
                    Controla tus materias y consulta tus horarios de forma fácil. Inicia sesión para empezar.
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center md:text-left">
                    <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Bienvenido de vuelta</h2>
                    <p class="mt-2 text-sm text-slate-500">Ingresa tus credenciales para continuar.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-700 mb-1">Correo Institucional</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                            class="w-full border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm px-4 py-3 transition-colors" 
                            placeholder="ejemplo@uaslp.mx">
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="password" class="block text-sm font-bold text-slate-700">Contraseña</label>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" 
                            class="w-full border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm px-4 py-3 transition-colors"
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                        <label for="remember_me" class="ml-2 block text-sm text-slate-600 font-medium">Mantener sesión iniciada</label>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition-all">
                            Iniciar Sesión
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm text-slate-500">
                    ¿No tienes una cuenta? 
                    <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-500 transition-colors">Regístrate aquí</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>