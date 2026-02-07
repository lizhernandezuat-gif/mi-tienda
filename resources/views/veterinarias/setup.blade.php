<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Veterinaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold text-center text-purple-700 mb-6">Alta de Nueva Veterinaria</h2>

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">¡Ups! Algo salió mal:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
        <form method="POST" action="{{ route('veterinarias.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nombre de la Clínica</label>
                <input type="text" name="nombre_veterinaria" class="w-full border p-2 rounded" placeholder="Ej: Patitas Felices" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Dirección</label>
                <input type="text" name="direccion" class="w-full border p-2 rounded" placeholder="Calle y Número" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Teléfono</label>
                <input type="text" name="telefono" class="w-full border p-2 rounded" placeholder="555-000-0000" required>
            </div>

            <hr class="my-6 border-gray-300">

            <h3 class="text-lg font-semibold text-gray-600 mb-4">Datos del Dueño (Admin)</h3>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Tu Nombre</label>
                <input type="text" name="name" class="w-full border p-2 rounded" placeholder="Dr. Tu Nombre" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Correo (Para Login)</label>
                <input type="email" name="email" class="w-full border p-2 rounded" placeholder="correo@ejemplo.com" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Contraseña</label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </div>

            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-lg shadow transition duration-200">
                🚀 Registrar y Entrar
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700">← Volver al Login</a>
        </div>
    </div>

</body>
</html>