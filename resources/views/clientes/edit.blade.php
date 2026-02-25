@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-gray-900">Editar Cliente</h1>
        {{-- Usamos bg-gray-100 para un botón de cancelar neutral y limpio --}}
        <a href="{{ route('clientes.index') }}" 
           class="text-custom-primary font-bold bg-gray-100 px-5 py-2 rounded-xl hover:bg-gray-200 transition flex items-center shadow-sm">
            &larr; Cancelar
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        
        {{-- Header dinámico: Eliminamos el degradado a rosa fijo --}}
        <div class="bg-custom-primary px-8 py-8 text-white relative">
            {{-- Textura sutil para dar calidad al fondo --}}
            <div class="absolute inset-0 opacity-10 bg-black/5" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
            
            <div class="relative z-10">
                <h2 class="text-2xl font-black italic">Editando a: {{ $cliente->nombre }}</h2>
                {{-- Opacidad blanca para el subtítulo, adaptabilidad total --}}
                <p class="text-white/80 text-sm mt-1 font-medium">Actualiza la información de contacto del propietario.</p>
            </div>
        </div>

        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nombre --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-1 ml-1">Nombre Completo <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" 
                           class="w-full rounded-xl border-gray-200 shadow-sm focus:border-custom-primary focus:ring-2 focus:ring-custom-primary/20 py-3 px-4 border bg-gray-50/50 transition-all font-semibold">
                    @error('nombre') <p class="text-red-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                {{-- Teléfono --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1 ml-1">Teléfono Móvil <span class="text-red-500">*</span></label>
                    <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" 
                           class="w-full rounded-xl border-gray-200 shadow-sm focus:border-custom-primary focus:ring-2 focus:ring-custom-primary/20 py-3 px-4 border bg-gray-50/50 transition-all">
                    @error('telefono') <p class="text-red-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                {{-- Correo --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1 ml-1">Correo Electrónico</label>
                    <input type="email" name="email" value="{{ old('email', $cliente->email) }}" 
                           class="w-full rounded-xl border-gray-200 shadow-sm focus:border-custom-primary focus:ring-2 focus:ring-custom-primary/20 py-3 px-4 border bg-gray-50/50 transition-all">
                    @error('email') <p class="text-red-500 text-xs font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                {{-- Domicilio --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-1 ml-1">Domicilio</label>
                    <input type="text" name="domicilio" value="{{ old('domicilio', $cliente->domicilio) }}" 
                           class="w-full rounded-xl border-gray-200 shadow-sm focus:border-custom-primary focus:ring-2 focus:ring-custom-primary/20 py-3 px-4 border bg-gray-50/50 transition-all">
                </div>
            </div>

            <div class="pt-8 border-t border-gray-100 flex justify-end">
                {{-- Botón con brillo dinámico para no usar colores oscuros fijos --}}
                <button type="submit" 
                        class="px-10 py-4 rounded-2xl text-white font-black bg-custom-primary shadow-lg hover:brightness-110 transform hover:-translate-y-1 transition-all active:scale-95 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection