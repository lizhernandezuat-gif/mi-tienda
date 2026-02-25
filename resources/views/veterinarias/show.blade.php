@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        
        {{-- Header Dinámico: bg-custom-primary --}}
        <div class="bg-custom-primary px-8 py-12 text-white flex flex-col md:flex-row justify-between items-center relative overflow-hidden">
            {{-- Efecto de brillo de fondo para dar profundidad al color --}}
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-black tracking-tight drop-shadow-sm">{{ $veterinaria->nombre }}</h1>
                <p class="text-white/90 mt-3 italic text-lg md:text-xl font-medium">{{ $veterinaria->slogan ?? 'Cuidando a tu mascota' }}</p>
            </div>

            <div class="mt-6 md:mt-0 h-24 w-24 bg-white/20 backdrop-blur-md text-white rounded-2xl flex items-center justify-center font-black text-4xl shadow-2xl border border-white/30 relative z-10 transform rotate-3">
                {{ substr($veterinaria->nombre, 0, 2) }}
            </div>
        </div>

        <div class="p-8 md:p-12 grid grid-cols-1 md:grid-cols-2 gap-12">
            
            <div class="space-y-10">
                <div class="group">
                    <label class="flex items-center text-xs font-black text-custom-primary uppercase tracking-[0.2em] mb-3">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Ubicación Principal
                    </label>
                    <p class="text-xl text-gray-800 font-semibold border-l-4 border-custom-primary pl-5 transition-all group-hover:border-l-8">{{ $veterinaria->direccion }}</p>
                </div>

                <div class="group">
                    <label class="flex items-center text-xs font-black text-custom-primary uppercase tracking-[0.2em] mb-3">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Línea de Contacto
                    </label>
                    <p class="text-xl text-gray-800 font-semibold border-l-4 border-custom-primary pl-5 transition-all group-hover:border-l-8">{{ $veterinaria->telefono }}</p>
                </div>
            </div>

            <div class="space-y-10">
                <div>
                    <label class="flex items-center text-xs font-black text-custom-primary uppercase tracking-[0.2em] mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Disponibilidad
                    </label>
                    <div class="inline-flex items-center px-6 py-3 bg-custom-light text-custom-primary rounded-2xl text-lg font-black shadow-sm border border-custom-primary/10">
                        {{ $veterinaria->horario ?? 'Horario no definido' }}
                    </div>
                </div>

                <div>
                    <label class="flex items-center text-xs font-black text-custom-primary uppercase tracking-[0.2em] mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Identificación Fiscal
                    </label>
                    <div class="bg-gray-50 px-5 py-3 rounded-xl border border-gray-200 inline-flex items-center">
                        <code class="text-lg text-gray-600 font-mono font-bold">{{ $veterinaria->rfc ?? 'SIN REGISTRO' }}</code>
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-gray-50 px-8 py-8 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <a href="{{ route('clientes.index') }}" class="text-sm text-gray-400 hover:text-custom-primary font-bold transition-all flex items-center gap-2 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:-translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Regresar al panel
            </a>
            
            <a href="{{ route('veterinarias.edit') }}" class="w-full sm:w-auto bg-custom-primary text-white px-10 py-4 rounded-2xl shadow-xl hover:brightness-110 hover:-translate-y-1 transition-all transform font-black flex items-center justify-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Actualizar Perfil
            </a>
        </div>
    </div>
</div>
@endsection