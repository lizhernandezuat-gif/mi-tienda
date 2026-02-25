<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Veterinaria | DogCat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Definimos la variable aquí también por si no carga app.css aún */
        :root {
            --primary-color: {{ $veterinaria->color_principal ?? '#7c3aed' }}; 
        }
        .bg-custom-primary { background-color: var(--primary-color); }
        .text-custom-primary { color: var(--primary-color); }
        .border-custom-primary { border-color: var(--primary-color); }
        .focus-ring-custom:focus { --tw-ring-color: var(--primary-color); border-color: var(--primary-color); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- Cabecera: Eliminamos gradientes fijos a rosa/morado --}}
    <div class="bg-custom-primary pb-32 pt-12 px-4 shadow-lg relative overflow-hidden">
        {{-- Efecto decorativo sutil para que el fondo no sea plano --}}
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        
        <div class="max-w-4xl mx-auto flex justify-between items-center relative z-10">
            <div class="flex items-center gap-3 text-white">
                <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm border border-white/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Registro de Nueva Veterinaria</h1>
                    <p class="text-white/80 text-sm italic">Configura tu espacio de trabajo en segundos.</p>
                </div>
            </div>

            <a href="{{ route('home') }}" class="text-white/90 hover:text-white flex items-center gap-2 transition-colors font-medium text-sm bg-white/10 px-4 py-2 rounded-full hover:bg-white/20 border border-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver
            </a>
        </div>
    </div>

    <div class="flex-grow px-4 -mt-20 mb-12 relative z-20">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
            
            <div class="bg-gray-50 border-b border-gray-100 px-8 py-5 flex justify-between items-center">
                <h2 class="text-custom-primary font-bold text-lg flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Datos del Negocio y Administrador
                </h2>
                <span class="px-3 py-1 bg-custom-primary/10 text-custom-primary text-xs font-bold rounded-full uppercase tracking-wider">
                    Paso Único
                </span>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 p-4 border-l-4 border-red-500 m-8 mb-0 rounded-r-lg">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-red-800">Atención:</h3>
                            <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('veterinarias.store') }}" class="p-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    
                    {{-- Sección Clínica --}}
                    <div class="space-y-6">
                        <h3 class="text-gray-400 text-xs font-black uppercase tracking-widest flex items-center gap-2">
                            <span class="w-8 h-px bg-gray-200"></span> Identidad de la Clínica
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre del Negocio <span class="text-red-500">*</span></label>
                                <input type="text" name="nombre_veterinaria" value="{{ old('nombre_veterinaria') }}" 
                                       class="w-full rounded-xl border-gray-200 border p-3 focus:ring-2 focus-ring-custom outline-none transition shadow-sm" placeholder="Ej: Clínica San Roque" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Dirección <span class="text-red-500">*</span></label>
                                <input type="text" name="direccion" value="{{ old('direccion') }}" 
                                       class="w-full rounded-xl border-gray-200 border p-3 focus:ring-2 focus-ring-custom outline-none transition shadow-sm" placeholder="Calle, Número y Colonia" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono <span class="text-red-500">*</span></label>
                                <input type="text" name="telefono" value="{{ old('telefono') }}" 
                                       class="w-full rounded-xl border-gray-200 border p-3 focus:ring-2 focus-ring-custom outline-none transition shadow-sm" placeholder="555-000-0000" required>
                            </div>
                        </div>
                    </div>

                    {{-- Sección Administrador --}}
                    <div class="space-y-6">
                        <h3 class="text-gray-400 text-xs font-black uppercase tracking-widest flex items-center gap-2">
                            <span class="w-8 h-px bg-gray-200"></span> Datos del Administrador
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tu Nombre Completo <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" 
                                       class="w-full rounded-xl border-gray-200 border p-3 focus:ring-2 focus-ring-custom outline-none transition shadow-sm" placeholder="Dr. Juan Pérez" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Correo (Login) <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" 
                                       class="w-full rounded-xl border-gray-200 border p-3 focus:ring-2 focus-ring-custom outline-none transition shadow-sm" placeholder="admin@tuveterinaria.com" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Contraseña <span class="text-red-500">*</span></label>
                                <input type="password" name="password" 
                                       class="w-full rounded-xl border-gray-200 border p-3 focus:ring-2 focus-ring-custom outline-none transition shadow-sm" placeholder="••••••••" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-6">
                    <p class="text-sm text-gray-500">
                        ¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="font-bold text-custom-primary hover:brightness-90 transition">Inicia Sesión aquí</a>
                    </p>
                    
                    <button type="submit" 
                            class="w-full md:w-auto bg-custom-primary text-white font-bold py-4 px-12 rounded-2xl shadow-xl hover:brightness-110 transform hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Comenzar ahora
                    </button>
                </div>

            </form>
        </div>
        
        <p class="text-center text-gray-400 text-xs mt-8">© 2026 DogCat System. La tecnología al servicio de tus mascotas.</p>
    </div>

</body>
</html>