@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-gray-900">Registrar Cliente</h1>
        <a href="{{ route('clientes.index') }}" class="text-purple-600 hover:text-purple-900 font-bold bg-purple-50 hover:bg-purple-100 px-4 py-2 rounded-lg transition flex items-center shadow-sm">
            &larr; Volver
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-purple-600 to-pink-500 px-8 py-6">
            <h2 class="text-white text-xl font-bold">Datos del Propietario</h2>
            <p class="text-purple-100 text-sm mt-1">Ingresa la información de contacto del cliente.</p>
        </div>

        <form action="{{ route('clientes.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div class="bg-purple-50 p-4 rounded-xl border border-purple-100 flex items-center gap-4 mb-6">
                <div class="bg-white p-2 rounded-full shadow-sm text-purple-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Sucursal Asignada</label>
                    <div class="font-bold text-gray-800">{{ \App\Models\Veterinaria::first()->nombre ?? 'Matriz' }}</div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50" placeholder="Ej: Juan Pérez">
                @error('nombre') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Teléfono Móvil (10 dígitos) <span class="text-red-500">*</span></label>
                <input type="text" name="telefono" value="{{ old('telefono') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50" placeholder="Ej: 55 1234 5678">
                @error('telefono') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50" placeholder="Opcional">
                @error('email') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Domicilio</label>
                <input type="text" name="domicilio" value="{{ old('domicilio') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50" placeholder="Dirección completa">
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('clientes.index') }}" class="px-6 py-3 rounded-full text-gray-600 font-bold hover:bg-gray-100 transition">Cancelar</a>
                <button type="submit" class="px-8 py-3 rounded-full text-white font-bold bg-gradient-to-r from-purple-600 to-pink-600 hover:shadow-lg transform hover:-translate-y-0.5 transition">
                    Guardar Cliente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection