<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-4">Iniciar Sesión</h1>
            <form action="/login" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Contraseña:</label>
                    <input type="password" id="password" name="password" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                </div>

                <div class="mt-6 text-center">
    <p class="text-sm text-gray-600">¿Eres nuevo?</p>
    <a href="{{ route('veterinarias.setup') }}" class="text-purple-600 hover:text-purple-800 font-bold hover:underline">
        Registra tu Veterinaria Aquí
    </a>
</div>
                <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>