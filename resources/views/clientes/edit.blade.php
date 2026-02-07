@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-gray-900">Editar Cliente</h1>
        <a href="{{ route('clientes.index') }}" class="text-purple-600 hover:text-purple-900 font-bold bg-purple-50 hover:bg-purple-100 px-4 py-2 rounded-lg transition flex items-center shadow-sm">
            &larr; Cancelar
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-purple-600 to-pink-500 px-8 py-6">
            <h2 class="text-white text-xl font-bold">Editando a: {{ $cliente->nombre }}</h2>
            <p class="text-purple-100 text-sm mt-1">Actualiza la información de contacto.</p>
        </div>

        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50">
                @error('nombre') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Teléfono Móvil (10 dígitos) <span class="text-red-500">*</span></label>
                <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50">
                @error('telefono') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email', $cliente->email) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50">
                @error('email') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Domicilio</label>
                <input type="text" name="domicilio" value="{{ old('domicilio', $cliente->domicilio) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50">
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-8 py-3 rounded-full text-white font-bold bg-gradient-to-r from-purple-600 to-pink-600 hover:shadow-lg transform hover:-translate-y-0.5 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection