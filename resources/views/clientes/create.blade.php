@extends('layouts.app')

@section('titulo', 'Nuevo Cliente')

@section('content')

<div class="max-w-4xl mx-auto">
    
    <div class="bg-gradient-to-r from-purple-600 to-pink-500 rounded-t-2xl p-6 text-white shadow-lg relative z-10">
        <h2 class="text-2xl font-bold mb-1">Registrar Nuevo Paciente</h2>
        <p class="text-purple-100 text-sm">Ingresa la información de contacto del dueño.</p>
    </div>

    <div class="bg-white rounded-b-2xl shadow-xl p-8 border-x border-b border-gray-100 relative z-0">

        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="nombre" class="block text-gray-700 font-bold mb-2">
                    Nombre Completo <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nombre" id="nombre" 
                       value="{{ old('nombre', request('nombre')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors text-gray-700"
                       placeholder="Ej: María González" required>
                @error('nombre')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="telefono" class="block text-gray-700 font-bold mb-2">
                    Teléfono Móvil (10 dígitos) <span class="text-red-500">*</span>
                </label>
                <input type="text" name="telefono" id="telefono" 
                       value="{{ old('telefono', request('telefono')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors text-gray-700"
                       placeholder="Ej: 5551234567" required>
                @error('telefono')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="block text-gray-700 font-bold mb-2">
                    Correo Electrónico <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" 
                       value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors text-gray-700"
                       placeholder="ejemplo@correo.com" required>
                @error('email')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="domicilio" class="block text-gray-700 font-bold mb-2">
                    Domicilio
                </label>
                <input type="text" name="domicilio" id="domicilio" 
                       value="{{ old('domicilio') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors text-gray-700"
                       placeholder="Calle, Número, Colonia...">
                @error('domicilio')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                <a href="{{ route('clientes.index') }}" class="text-gray-500 hover:text-gray-700 font-medium px-4 py-2 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-full shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    Registrar Paciente
                </button>
            </div>

        </form>
    </div>
</div>

@endsection