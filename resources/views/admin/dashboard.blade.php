<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Super Admin | Plan kok</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white font-sans antialiased">
    
    <div class="min-h-screen flex flex-col items-center justify-center p-6">
        
        <div class="text-6xl mb-4">👑</div>

        <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600 mb-2">
            Super Admin
        </h1>
        <p class="text-slate-400 text-lg mb-8">Centro de Control Global</p>
        
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl shadow-2xl max-w-md w-full">
            <h2 class="text-xl font-bold mb-6 border-b border-slate-700 pb-2 text-white">
                Estatus del Sistema
            </h2>
            
            <ul class="space-y-4 mb-8">
                <li class="flex items-center justify-between">
                    <span class="text-slate-300">Login Unificado</span>
                    <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Activo</span>
                </li>
                <li class="flex items-center justify-between">
                    <span class="text-slate-300">Multi-Tenancy</span>
                    <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Seguro</span>
                </li>
                <li class="flex items-center justify-between">
                    <span class="text-slate-300">Encriptación</span>
                    <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Bcrypt</span>
                </li>
            </ul>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl transition duration-200 shadow-lg flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                    </svg>
                    Cerrar Sesión Global
                </button>
            </form>
        </div>

        <p class="mt-8 text-slate-600 text-sm">
            Sistema corriendo en Laravel v{{ Illuminate\Foundation\Application::VERSION }}
        </p>
    </div>

</body>
</html>