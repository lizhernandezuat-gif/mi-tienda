@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl mb-8">
        <div class="p-8 bg-gradient-to-r from-purple-500 to-indigo-600 text-white">
            <h1 class="text-4xl font-extrabold">¡Hola! 👋</h1>
            <p class="mt-2 text-lg opacity-90">Bienvenido al panel de administración de <strong>{{ $veterinaria->nombre }}</strong>.</p>
        </div>
        
        <div class="p-8 bg-white grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('clientes.index') }}" class="block p-6 border-2 border-purple-100 rounded-xl hover:border-purple-500 hover:shadow-lg transition group bg-purple-50">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-purple-700 group-hover:text-purple-900">🐶 Clientes</h3>
                    <span class="bg-purple-200 text-purple-700 py-1 px-3 rounded-full text-xs font-bold">Gestión</span>
                </div>
                <p class="text-gray-600 text-sm">Registra mascotas, dueños y consulta historiales.</p>
            </a>

            <div class="p-6 border border-gray-100 rounded-xl opacity-50 cursor-not-allowed">
                <h3 class="text-xl font-bold text-gray-400">🥩 Productos</h3>
                <p class="text-gray-400 text-sm mt-2">Próximamente...</p>
            </div>

            <div class="p-6 border border-gray-100 rounded-xl opacity-50 cursor-not-allowed">
                <h3 class="text-xl font-bold text-gray-400">💉 Servicios</h3>
                <p class="text-gray-400 text-sm mt-2">Próximamente...</p>
            </div>
        </div>
    </div>
</div>
@endsection