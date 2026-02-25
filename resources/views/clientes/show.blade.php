@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    {{-- Card de Información del Cliente --}}
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden mb-10 border border-gray-100">
        {{-- Header: Color sólido para máxima legibilidad --}}
        <div class="bg-custom-primary px-8 py-10 text-white flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
            {{-- Efecto decorativo sutil --}}
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <h1 class="text-4xl font-black tracking-tight" style="color: #ffffff; text-shadow: 0 1px 2px rgba(0,0,0,0.5);">{{ $cliente->nombre }}</h1>
                <p class="mt-2 flex items-center text-sm font-bold uppercase tracking-widest" style="color: rgba(255,255,255,0.9); text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Expediente abierto: {{ $cliente->created_at->format('d/m/Y') }}
                </p>
            </div>
            <div class="flex gap-3 relative z-10">
                <a href="{{ route('clientes.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-800 hover:bg-gray-200 rounded-xl font-black transition-all text-sm border border-gray-300 shadow-sm">
                    &larr; Volver
                </a>
                <a href="{{ route('clientes.edit', $cliente->id) }}" class="px-5 py-2.5 bg-white text-gray-900 rounded-xl font-black hover:scale-105 transition-all shadow-md text-sm flex items-center border border-gray-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Editar Perfil
                </a>
            </div>
        </div>
        
        {{-- Cintillo de contacto rápido --}}
        <div class="px-8 py-8 bg-gray-50 flex flex-wrap gap-10 md:gap-16">
            <div class="group">
                <span class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-1">📞 Teléfono Móvil</span>
                <span class="text-gray-900 font-black text-xl">{{ $cliente->telefono }}</span>
            </div>
            @if($cliente->email)
            <div class="group">
                <span class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-1">📧 Correo Electrónico</span>
                <span class="text-gray-900 font-bold text-xl">{{ $cliente->email }}</span>
            </div>
            @endif
            @if($cliente->domicilio)
            <div class="group">
                <span class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-1">🏠 Dirección Social</span>
                <span class="text-gray-900 font-medium text-xl">{{ $cliente->domicilio }}</span>
            </div>
            @endif
        </div>
    </div>

    {{-- Sección de Mascotas --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 flex items-center gap-3">
                🐾 Mascotas Vinculadas
                <span class="bg-gray-200 text-gray-800 text-sm font-black px-4 py-1 rounded-full border border-gray-300">{{ $cliente->mascotas->count() }}</span>
            </h2>
            <p class="text-gray-600 font-medium mt-1 italic">Historial clínico por paciente.</p>
        </div>
        
        <a href="{{ route('mascotas.create', $cliente->id) }}" class="inline-flex items-center px-8 py-4 bg-custom-primary text-white font-black rounded-2xl shadow-xl hover:brightness-110 transform hover:-translate-y-1 transition-all active:scale-95 border border-transparent">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Agregar Paciente
        </a>
    </div>

    @if($cliente->mascotas->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($cliente->mascotas as $mascota)
                
                @php
                    // Lógica de colores dinámica según el estado
                    $bordeColor = 'border-gray-200';
                    $estadoBg = 'bg-gray-200 text-gray-800';
                    
                    if($mascota->estado == 'Sano') { 
                        $bordeColor = 'border-emerald-300'; 
                        $estadoBg = 'bg-emerald-100 text-emerald-800 border border-emerald-200'; 
                    } elseif($mascota->estado == 'Hospitalizado') { 
                        $bordeColor = 'border-rose-400'; 
                        $estadoBg = 'bg-rose-500 text-white animate-pulse font-black shadow-lg shadow-rose-200'; 
                    } elseif($mascota->estado == 'En Tratamiento') { 
                        $bordeColor = 'border-amber-300'; 
                        $estadoBg = 'bg-amber-100 text-amber-800 font-bold border border-amber-200'; 
                    }
                @endphp

                <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border-2 {{ $bordeColor }} group flex flex-col overflow-hidden h-full transform hover:-translate-y-2">
                    
                    <div class="h-60 w-full bg-gray-100 relative overflow-hidden">
                        @if($mascota->foto)
                            <img src="{{ asset('storage/' . $mascota->foto) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-7xl text-gray-300">
                                @switch($mascota->especie)
                                    @case('Perro') 🐶 @break
                                    @case('Gato') 🐱 @break
                                    @case('Ave') 🐦 @break
                                    @default 🐾
                                @endswitch
                            </div>
                        @endif

                        <div class="absolute top-4 right-4 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $estadoBg }}">
                            {{ $mascota->estado }}
                        </div>
                    </div>
                    
                    <div class="p-6 flex-grow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-2xl font-black text-gray-900 leading-none">{{ $mascota->nombre }}</h3>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-tighter mt-1">{{ $mascota->raza ?? 'Raza no especificada' }}</p>
                            </div>
                            <span class="text-3xl" title="{{ $mascota->especie }}">
                                @switch($mascota->especie)
                                    @case('Perro') 🐶 @break
                                    @case('Gato') 🐱 @break
                                    @default 🐾
                                @endswitch
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-100 p-3 rounded-2xl text-center border border-gray-200">
                                <span class="block text-[10px] font-black text-gray-500 uppercase mb-1">Peso Actual</span>
                                <span class="font-black text-gray-900">{{ $mascota->peso ?? '-' }} kg</span>
                            </div>
                            <div class="bg-gray-100 p-3 rounded-2xl text-center border border-gray-200">
                                <span class="block text-[10px] font-black text-gray-500 uppercase mb-1">Edad Ref</span>
                                <span class="font-black text-gray-900">{{ $mascota->edad ?? '-' }} años</span>
                            </div>
                        </div>

                        @if($mascota->notas_medicas)
                            <div class="mt-5 bg-yellow-50 p-4 rounded-2xl border border-yellow-100">
                                <p class="text-[10px] font-black text-yellow-800 uppercase tracking-widest mb-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Notas Médicas
                                </p>
                                <p class="text-xs text-gray-800 italic line-clamp-2 leading-relaxed">"{{ $mascota->notas_medicas }}"</p>
                            </div>
                        @endif
                    </div>

                    <div class="bg-gray-50 border-t border-gray-200 p-4 flex gap-2">
                        <a href="{{ route('mascotas.edit', $mascota->id) }}" class="flex-1 py-3 bg-white hover:bg-gray-100 text-gray-800 rounded-xl font-black text-center transition-all text-xs uppercase tracking-widest shadow-sm border border-gray-300">
                            Editar
                        </a>
                        
                        <form action="{{ route('mascotas.destroy', $mascota->id) }}" method="POST" class="w-fit" onsubmit="return confirm('¿Eliminar a {{ $mascota->nombre }} del sistema?');">
                            @csrf @method('DELETE')
                            <button class="p-3 bg-white hover:bg-rose-500 text-gray-500 hover:text-white rounded-xl transition-all border border-gray-300 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- Estado vacío --}}
        <div class="bg-white rounded-3xl border-4 border-dashed border-gray-200 p-16 text-center">
            <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-6 border border-gray-200">
                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-2xl font-black text-gray-900 italic">Expediente vacío</h3>
            <p class="text-gray-600 mt-2 mb-8 font-medium">Este cliente aún no tiene mascotas vinculadas.</p>
            <a href="{{ route('mascotas.create', $cliente->id) }}" class="bg-custom-primary text-white font-black py-4 px-10 rounded-2xl shadow-xl hover:brightness-110 transition-all border border-transparent">
                Registrar primer paciente
            </a>
        </div>
    @endif
</div>
@endsection