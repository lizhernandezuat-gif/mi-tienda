<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Mi Tienda') }}</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
</head>
<body class="bg-gray-100 text-gray-800">
    <header class="bg-gradient-to-r from-purple-600 via-pink-500 to-indigo-600 text-white py-6">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">¡Bienvenido, {{ $user->name }}!</h1>
            <nav class="flex gap-4">
                <a href="{{ route('clientes.index') }}" class="px-4 py-2 bg-white/30 rounded-full hover:bg-white/50">Clientes</a>
                <a href="{{ route('productos.index') }}" class="px-4 py-2 bg-white/30 rounded-full hover:bg-white/50">Productos</a>
                <a href="{{ route('servicios.index') }}" class="px-4 py-2 bg-white/30 rounded-full hover:bg-white/50">Servicios</a>
            </nav>
        </div>
    </header>
    <main class="container mx-auto py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">Sucursal: {{ $veterinaria->nombre }}</h2>
            <p class="text-gray-600">Dirección: {{ $veterinaria->direccion }}</p>
            <p class="text-gray-600">Teléfono: {{ $veterinaria->telefono }}</p>
        </div>
    </main>
</body>
</html>
