@extends('layouts.app')

@section('titulo', 'Nuevo Cliente')

@section('content')

<div class="max-w-4xl mx-auto px-4">
    
    {{-- Header dinámico: Quitamos el degradado a rosa --}}
    <div class="bg-custom-primary rounded-t-3xl p-8 text-white shadow-lg relative overflow-hidden">
        {{-- Efecto de brillo sutil para evitar que el color se vea plano --}}
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
        
        <div class="relative z-10">
            <h2 class="text-3xl font-black mb-1">Registrar Nuevo Cliente</h2>
            <p class="text-white/80 text-sm font-medium italic">Ingresa la información de contacto para iniciar el expediente.</p>
        </div>
    </div>

    <div class="bg-white rounded-b-3xl shadow-2xl p-8 border-x border-b border-gray-100 relative z-0">

        <form action="{{ route('clientes.store') }}" method="POST" id="cliente-form">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nombre Completo --}}
                <div class="md:col-span-2">
                    <label for="nombre" class="block text-gray-700 font-bold mb-2 ml-1">
                        Nombre Completo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre" id="nombre" 
                           value="{{ old('nombre', request('nombre')) }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-custom-primary/20 focus:border-custom-primary transition-all text-gray-700 bg-gray-50/50"
                           placeholder="Ej: María González" required>
                    @error('nombre')
                        <p class="text-red-500 text-xs font-bold mt-1 ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teléfono --}}
                <div>
                    <label for="telefono" class="block text-gray-700 font-bold mb-2 ml-1">
                        Teléfono Móvil <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="telefono" id="telefono" 
                           value="{{ old('telefono', request('telefono')) }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-custom-primary/20 focus:border-custom-primary transition-all text-gray-700 bg-gray-50/50"
                           placeholder="Ej: 5551234567" required>
                    @error('telefono')
                        <p class="text-red-500 text-xs font-bold mt-1 ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Correo --}}
                <div>
                    <label for="email" class="block text-gray-700 font-bold mb-2 ml-1">
                        Correo Electrónico <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-custom-primary/20 focus:border-custom-primary transition-all text-gray-700 bg-gray-50/50"
                           placeholder="ejemplo@correo.com" required>
                    @error('email')
                        <p class="text-red-500 text-xs font-bold mt-1 ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Domicilio --}}
                <div class="md:col-span-2">
                    <label for="domicilio" class="block text-gray-700 font-bold mb-2 ml-1">
                        Domicilio
                    </label>
                    <input type="text" name="domicilio" id="domicilio" 
                           value="{{ old('domicilio') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-custom-primary/20 focus:border-custom-primary transition-all text-gray-700 bg-gray-50/50"
                           placeholder="Calle, Número, Colonia...">
                    @error('domicilio')
                        <p class="text-red-500 text-xs font-bold mt-1 ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex items-center justify-end gap-4 border-t border-gray-100 mt-8 pt-8">
                <a href="{{ route('clientes.index') }}" 
                   class="text-gray-400 hover:text-gray-600 font-bold px-6 py-3 transition-colors uppercase text-xs tracking-widest">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-custom-primary hover:brightness-110 text-white font-black py-4 px-10 rounded-2xl shadow-lg hover:shadow-custom-primary/30 transform hover:-translate-y-1 active:scale-95 transition-all duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Registrar Dueño
                </button>
            </div>

        </form>
    </div>
</div>

@endsection