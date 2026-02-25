<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Auth::user()->veterinaria->nombre ?? 'DogCat' }} - Panel</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
    :root {
        /* Tomamos el color de la base de datos o un violeta por defecto */
        --primary-color: {{ Auth::user()->veterinaria->settings->primary_color ?? '#9333ea' }};
    }

    /* 1. Fondos Sólidos */
    .bg-custom-primary { 
        background-color: var(--primary-color) !important; 
    }

    /* 2. Textos dinámicos */
    .text-custom-primary { 
        color: var(--primary-color) !important; 
    }

    /* 3. Bordes dinámicos */
    .border-custom-primary { 
        border-color: var(--primary-color) !important; 
    }

    /* 4. Fondos Claros Adaptables (bg-custom-light) */
    /* Usamos una versión muy transparente del color primario */
    .bg-custom-light {
    /* Si el color es negro, esto dará un gris muy suave */
    background-color: var(--primary-color) !important;
    opacity: 0.08 !important; 
  }

  /* Añade esta nueva clase para asegurar contraste en textos secundarios */
   .text-contrast-muted {
    color: #4b5563 !important; /* Gris oscuro (gray-600) para que se lea siempre */
        }
    
    /* Alternativa para cuando el filtro no basta: un contenedor con fondo blanco y el primario encima */
    .bg-custom-soft {
        background-color: color-mix(in srgb, var(--primary-color), white 90%);
    }

    /* 5. Estados Hover Dinámicos */
    .hover-brightness:hover {
        filter: brightness(90%);
        transition: all 0.3s;
    }

    /* 6. Header con Estilo */
    header.bg-custom-primary {
        position: relative;
        overflow: hidden;
    }
    header.bg-custom-primary::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(255,255,255,0.15), rgba(0,0,0,0.05));
        pointer-events: none;
    }

    body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
</style>
</head>

<body class="bg-gray-50 text-gray-900">
    
    <header class="sticky top-0 z-50 bg-custom-primary text-white shadow-xl h-24">
        <div class="container mx-auto px-6 py-3 flex items-center justify-between h-full relative z-10">
            
            <div class="flex items-center gap-4">
                {{-- Logo Círculo Dinámico --}}
                <a href="{{ route('veterinarias.show') }}" 
                   class="h-12 w-12 rounded-full bg-white/20 flex items-center justify-center font-black text-lg hover:bg-white hover:text-custom-primary transition-all duration-300 shadow-inner border border-white/30"
                   title="Mi Veterinaria">
                   {{ substr(Auth::user()->veterinaria->nombre ?? 'VC', 0, 2) }}
                </a>

                <a href="/" class="group flex flex-col justify-center">
                    <div class="text-xl font-black group-hover:opacity-80 transition leading-tight">
                        {{ Auth::user()->veterinaria->nombre ?? 'Mi Veterinaria' }}
                    </div>
                    <div class="text-xs text-white/70 font-bold tracking-widest uppercase">
                        {{ Auth::user()->veterinaria->slogan ?? 'Gestión Veterinaria' }}
                    </div>
                </a>
            </div>

            {{-- Navegación Principal --}}
            <nav class="hidden md:flex items-center gap-3">
                
                <a href="{{ route('clientes.index') }}" 
                   class="px-5 py-2 rounded-xl font-bold transition-all shadow-sm
                   {{ request()->routeIs('clientes.*') ? 'bg-white text-custom-primary scale-105' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                    Clientes
                </a>

                <a href="{{ route('citas.index') }}" 
                   class="px-5 py-2 rounded-xl font-bold transition-all shadow-sm
                   {{ request()->routeIs('citas.*') ? 'bg-white text-custom-primary scale-105' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                    Agenda
                </a>

                <a href="{{ route('settings.index') }}" 
                   class="px-5 py-2 rounded-xl font-bold transition-all shadow-sm flex items-center gap-2
                   {{ request()->routeIs('settings.*') ? 'bg-white text-custom-primary scale-105' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Ajustes
                </a>
            </nav>

            {{-- Menú Móvil --}}
            <div class="md:hidden">
                <button class="p-2 rounded-lg bg-white/10 text-white">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
            </div>
            
        </div>
    </header>

    <main class="py-8 min-h-screen">
        {{-- Aquí se inyectan las vistas --}}
        @yield('content')
    </main>

    {{-- Footer sutil --}}
    <footer class="py-6 text-center text-gray-400 text-sm">
        &copy; {{ date('Y') }} {{ Auth::user()->veterinaria->nombre }} - Impulsado por DogCat
    </footer>

</body>
</html>