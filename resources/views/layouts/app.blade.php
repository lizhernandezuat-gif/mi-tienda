<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ \App\Models\Veterinaria::first()?->nombre ?? 'Mollis' }} - Sistema</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>body{font-family:system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;}</style>
</head>
<body class="bg-white text-[#1b1b18]">
    
    <header class="sticky top-0 z-50 bg-gradient-to-r from-pink-500 via-purple-600 to-indigo-600 text-white shadow-2xl h-32">
        <div class="container mx-auto px-6 py-3 flex items-center justify-between h-full">
            
            <div class="flex items-center gap-4">
                
                <a href="{{ route('veterinarias.show') }}" 
                   class="h-14 w-14 rounded-full bg-white/20 flex items-center justify-center font-extrabold text-xl hover:bg-white hover:text-purple-600 transition duration-300 shadow-lg cursor-pointer border-2 border-transparent hover:border-pink-200"
                   title="Ver perfil de la veterinaria">
                    MT
                </a>

                <a href="/" class="group flex flex-col justify-center">
                    <div class="text-2xl font-extrabold group-hover:text-pink-200 transition">
                        {{ \App\Models\Veterinaria::first()?->nombre ?? 'Configurar Sistema' }}
                    </div>
                    <div class="text-xs text-white/80 font-medium tracking-wide">
                        {{ \App\Models\Veterinaria::first()?->slogan ?? 'Bienvenido' }}
                    </div>
                </a>
            </div>

            <nav class="flex items-center gap-4">
                <a href="{{ route('clientes.index') }}" class="px-5 py-2 rounded-full bg-white/20 hover:bg-white/30 font-semibold transition backdrop-blur-sm shadow-sm">
                    Clientes
                </a>
                <a href="#" class="px-5 py-2 rounded-full bg-white/10 hover:bg-white/20 transition text-white/90">
                    Productos
                </a>
                <a href="#" class="px-5 py-2 rounded-full bg-white/10 hover:bg-white/20 transition text-white/90">
                    Servicios
                </a>
            </nav>

            
    </header>

    <main class="py-6">
        @yield('content')
    </main>
    </body>
</html>