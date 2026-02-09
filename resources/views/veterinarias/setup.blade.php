<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Veterinaria | Plan kok</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <div class="bg-gradient-to-r from-purple-700 via-purple-600 to-pink-500 pb-32 pt-12 px-4 shadow-lg">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            
            <div class="flex items-center gap-3 text-white">
                <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Registro de Nueva Veterinaria</h1>
                    <p class="text-purple-100 text-sm">Configura tu espacio de trabajo en segundos.</p>
                </div>
            </div>

            <a href="{{ route('home') }}" class="text-white/80 hover:text-white flex items-center gap-2 transition-colors font-medium text-sm bg-white/10 px-4 py-2 rounded-full hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver al Inicio
            </a>
        </div>
    </div>

    <div class="flex-grow px-4 -mt-20 mb-12">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-xl overflow-hidden border border-gray-100">
            
            <div class="bg-gray-50 border-b border-gray-100 px-8 py-4 flex justify-between items-center">
                <h2 class="text-purple-700 font-bold text-lg flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                    </svg>
                    Datos del Negocio y Administrador
                </h2>
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Paso 1 de 1</span>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 p-4 border-l-4 border-red-500 m-8 mb-0">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Hay errores en el formulario:</h3>
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
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div>
                        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-4 border-b pb-2">Identidad de la Clínica</h3>
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Negocio <span class="text-red-500">*</span></label>
                                <input type="text" name="nombre_veterinaria" value="{{ old('nombre_veterinaria') }}" class="w-full rounded-lg border-gray-300 border focus:ring-purple-500 focus:border-purple-500 p-2.5 shadow-sm transition" placeholder="Ej: Clínica San Roque" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dirección Completa <span class="text-red-500">*</span></label>
                                <input type="text" name="direccion" value="{{ old('direccion') }}" class="w-full rounded-lg border-gray-300 border focus:ring-purple-500 focus:border-purple-500 p-2.5 shadow-sm transition" placeholder="Calle, Número y Colonia" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono de Contacto <span class="text-red-500">*</span></label>
                                <input type="text" name="telefono" value="{{ old('telefono') }}" class="w-full rounded-lg border-gray-300 border focus:ring-purple-500 focus:border-purple-500 p-2.5 shadow-sm transition" placeholder="555-000-0000" required>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-4 border-b pb-2">Datos del Administrador</h3>
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tu Nombre Completo <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 border focus:ring-purple-500 focus:border-purple-500 p-2.5 shadow-sm transition" placeholder="Dr. Juan Pérez" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico (Login) <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300 border focus:ring-purple-500 focus:border-purple-500 p-2.5 shadow-sm transition" placeholder="admin@tuveterinaria.com" required>
                                <p class="text-xs text-gray-500 mt-1">Este será tu usuario principal.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña Maestra <span class="text-red-500">*</span></label>
                                <input type="password" name="password" class="w-full rounded-lg border-gray-300 border focus:ring-purple-500 focus:border-purple-500 p-2.5 shadow-sm transition" placeholder="••••••••" required>
                                <p class="text-xs text-gray-500 mt-1">Mínimo 6 caracteres.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        ¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="font-bold text-purple-600 hover:text-purple-800 hover:underline">Inicia Sesión aquí</a>
                    </p>
                    
                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                         Crear Veterinaria
                    </button>
                </div>

            </form>
        </div>
        
        <p class="text-center text-gray-400 text-sm mt-8">© 2026 Plan kok. Todos los derechos reservados.</p>
    </div>

</body>
</html>