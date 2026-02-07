@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-10 border border-gray-100">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-8 text-white flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold">{{ $cliente->nombre }}</h1>
                <p class="text-purple-200 mt-1 flex items-center text-sm font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Cliente desde: {{ $cliente->created_at->format('d/m/Y') }}
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('clientes.index') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg font-bold backdrop-blur-sm transition text-sm border border-white/20">
                    &larr; Volver
                </a>
                <a href="{{ route('clientes.edit', $cliente->id) }}" class="px-4 py-2 bg-yellow-400 text-yellow-900 rounded-lg font-bold hover:bg-yellow-300 transition shadow-lg text-sm flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Editar Datos
                </a>
            </div>
        </div>
        
        <div class="px-8 py-6 bg-gray-50 flex flex-wrap gap-12 text-sm border-b border-gray-100">
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Teléfono</span>
                <span class="text-gray-900 font-bold text-lg">{{ $cliente->telefono }}</span>
            </div>
            @if($cliente->email)
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email</span>
                <span class="text-gray-900 font-medium text-lg">{{ $cliente->email }}</span>
            </div>
            @endif
            @if($cliente->domicilio)
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Domicilio</span>
                <span class="text-gray-900 font-medium text-lg">{{ $cliente->domicilio }}</span>
            </div>
            @endif
        </div>
    </div>

    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-900 flex items-center gap-2">
                🐾 Expediente de Mascotas
                <span class="bg-purple-100 text-purple-800 text-xs font-bold px-2 py-1 rounded-full">{{ $cliente->mascotas->count() }}</span>
            </h2>
            <p class="text-gray-500 text-sm mt-1">Pacientes registrados a nombre de este cliente.</p>
        </div>
        
        <a href="{{ route('mascotas.create', $cliente->id) }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold rounded-full shadow-lg hover:from-pink-600 hover:to-purple-700 transform hover:-translate-y-0.5 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Agregar Paciente
        </a>
    </div>

    @if($cliente->mascotas->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cliente->mascotas as $mascota)
                
                @php
                    $bordeColor = 'border-gray-200';
                    $estadoBg = 'bg-gray-100 text-gray-800';
                    
                    if($mascota->estado == 'Sano') { 
                        $bordeColor = 'border-green-400'; 
                        $estadoBg = 'bg-green-100 text-green-800'; 
                    } elseif($mascota->estado == 'Hospitalizado') { 
                        $bordeColor = 'border-red-500 border-2'; 
                        $estadoBg = 'bg-red-100 text-red-800 animate-pulse font-bold'; 
                    } elseif($mascota->estado == 'En Tratamiento') { 
                        $bordeColor = 'border-yellow-400 border-2'; 
                        $estadoBg = 'bg-yellow-100 text-yellow-800 font-bold'; 
                    }
                @endphp

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border {{ $bordeColor }} group relative flex flex-col h-full">
                    
                    <div class="h-56 w-full bg-gray-200 relative overflow-hidden group">
                        @if($mascota->foto)
                            <img src="{{ asset('storage/' . $mascota->foto) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-100 to-pink-100 text-6xl">
                                @switch($mascota->especie)
                                    @case('Perro') 🐶 @break
                                    @case('Gato') 🐱 @break
                                    @case('Ave') 🐦 @break
                                    @case('Reptil') 🦎 @break
                                    @default 🐾
                                @endswitch
                            </div>
                        @endif

                        <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wide shadow-sm {{ $estadoBg }}">
                            {{ $mascota->estado }}
                        </div>
                    </div>
                    
                    <div class="p-6 flex-grow">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-extrabold text-gray-900 leading-tight">{{ $mascota->nombre }}</h3>
                                <p class="text-sm text-gray-500 font-medium">{{ $mascota->raza ?? 'Raza desconocida' }}</p>
                            </div>
                            <span class="text-2xl" title="{{ $mascota->especie }}">
                                @switch($mascota->especie)
                                    @case('Perro') 🐶 @break
                                    @case('Gato') 🐱 @break
                                    @default 🐾
                                @endswitch
                            </span>
                        </div>
                        
                        <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                            <div class="bg-gray-50 p-2 rounded-lg text-center border border-gray-100">
                                <span class="block text-[10px] font-bold text-gray-400 uppercase">PESO</span>
                                <span class="font-bold text-gray-800">{{ $mascota->peso ?? '-' }} kg</span>
                            </div>
                            <div class="bg-gray-50 p-2 rounded-lg text-center border border-gray-100">
                                <span class="block text-[10px] font-bold text-gray-400 uppercase">EDAD</span>
                                <span class="font-bold text-gray-800">{{ $mascota->edad ?? '-' }} años</span>
                            </div>
                        </div>

                        @if($mascota->notas_medicas)
                            <div class="mt-4 bg-purple-50 p-3 rounded-lg border border-purple-100">
                                <p class="text-xs font-bold text-purple-800 mb-1">Notas:</p>
                                <p class="text-xs text-gray-600 line-clamp-2">{{ $mascota->notas_medicas }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="border-t border-gray-100 flex divide-x divide-gray-100 bg-gray-50">
                        

                        <a href="{{ route('mascotas.edit', $mascota->id) }}" class="w-1/3 py-4 hover:bg-white text-gray-500 hover:text-purple-600 font-bold text-center transition text-sm flex items-center justify-center gap-2 group">
                            ✏️ <span class="hidden md:inline group-hover:underline">Editar</span>
                        </a>
                        
                        <form action="{{ route('mascotas.destroy', $mascota->id) }}" method="POST" class="w-1/3" onsubmit="return confirm('¿Borrar a {{ $mascota->nombre }}?');">
                            @csrf @method('DELETE')
                            <button class="w-full h-full py-4 hover:bg-white text-gray-500 hover:text-red-600 font-bold text-center transition text-sm flex items-center justify-center gap-2 group">
                                🗑️ <span class="hidden md:inline group-hover:underline">Borrar</span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl border-2 border-dashed border-gray-300 p-12 text-center">
            <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900">No hay mascotas registradas</h3>
            <p class="text-gray-500 mt-2 mb-6">Este cliente aún no tiene pacientes asignados.</p>
            <a href="{{ route('mascotas.create', $cliente->id) }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-bold rounded-lg hover:bg-purple-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                Registrar la primera mascota
            </a>
        </div>
    @endif

</div>
@endsection