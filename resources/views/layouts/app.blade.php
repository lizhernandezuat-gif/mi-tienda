<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Auth::user()->veterinaria->nombre ?? 'Sistema SaaS' }} - Panel</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>body{font-family:system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;}</style>
</head>
<body class="bg-gray-50 text-[#1b1b18]">
    
    <header class="sticky top-0 z-50 bg-gradient-to-r from-pink-500 via-purple-600 to-indigo-600 text-white shadow-2xl h-24">
        <div class="container mx-auto px-6 py-3 flex items-center justify-between h-full">
            
            <div class="flex items-center gap-4">
                
                <a href="{{ route('veterinarias.show') }}" 
                   class="h-12 w-12 rounded-full bg-white/20 flex items-center justify-center font-extrabold text-lg hover:bg-white hover:text-purple-600 transition duration-300 shadow-lg cursor-pointer border-2 border-transparent hover:border-pink-200"
                   title="Configuración de la Veterinaria">
                   MT
                </a>

                <a href="/" class="group flex flex-col justify-center">
                    <div class="text-xl font-extrabold group-hover:text-pink-200 transition leading-tight">
                        {{ Auth::user()->veterinaria->nombre ?? 'Mi Veterinaria' }}
                    </div>
                    <div class="text-xs text-white/80 font-medium tracking-wide">
                        {{ Auth::user()->veterinaria->slogan ?? 'Panel de Control' }}
                    </div>
                </a>
            </div>

            <nav class="hidden md:flex items-center gap-2">
                
                <a href="{{ route('clientes.index') }}" 
                   class="px-4 py-2 rounded-full font-semibold transition backdrop-blur-sm shadow-sm
                   {{ request()->routeIs('clientes.*') ? 'bg-white text-purple-700' : 'bg-white/20 hover:bg-white/30 text-white' }}">
                   Clientes
                </a>

                <a href="{{ route('citas.index') }}" 
                   class="px-4 py-2 rounded-full font-semibold transition backdrop-blur-sm shadow-sm
                   {{ request()->routeIs('citas.*') ? 'bg-white text-purple-700' : 'bg-white/20 hover:bg-white/30 text-white' }}">
                   Citas
                </a>

                <a href="#" class="px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 transition text-white/90">
                    Productos
                </a>
                <a href="#" class="px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 transition text-white/90">
                    Servicios
                </a>
            </nav>

            <div class="md:hidden">
                <button class="text-white hover:text-pink-200 focus:outline-none">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
            </div>
            
        </div>
    </header>

    <main class="py-8 min-h-screen">
        @yield('content')
    </main>

</body>
</html>