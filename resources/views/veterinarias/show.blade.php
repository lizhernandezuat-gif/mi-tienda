@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-10 text-white flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight">{{ $veterinaria->nombre }}</h1>
                <p class="text-purple-100 mt-2 italic text-lg">{{ $veterinaria->slogan ?? 'Cuidando a tu mascota' }}</p>
            </div>
            <div class="h-20 w-20 bg-white/20 backdrop-blur-sm text-white rounded-full flex items-center justify-center font-bold text-3xl shadow-inner border-2 border-white/30">
                {{ substr($veterinaria->nombre, 0, 2) }}
            </div>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-10">
            
            <div class="space-y-8">
                <div>
                    <label class="flex items-center text-xs font-bold text-purple-600 uppercase tracking-wider mb-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Dirección
                    </label>
                    <p class="text-xl text-gray-800 font-medium border-l-4 border-purple-200 pl-4">{{ $veterinaria->direccion }}</p>
                </div>

                <div>
                    <label class="flex items-center text-xs font-bold text-purple-600 uppercase tracking-wider mb-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Teléfono
                    </label>
                    <p class="text-xl text-gray-800 font-medium border-l-4 border-purple-200 pl-4">{{ $veterinaria->telefono }}</p>
                </div>
            </div>

            <div class="space-y-8">
                <div>
                    <label class="flex items-center text-xs font-bold text-pink-600 uppercase tracking-wider mb-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Horario de Atención
                    </label>
                    <div class="mt-1">
                        <span class="bg-green-100 text-green-800 px-4 py-2 rounded-lg text-md font-bold inline-block shadow-sm">
                            {{ $veterinaria->horario ?? 'No especificado' }}
                        </span>
                    </div>
                </div>

                <div>
                    <label class="flex items-center text-xs font-bold text-pink-600 uppercase tracking-wider mb-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        RFC / Registro
                    </label>
                    <p class="text-lg text-gray-600 font-medium font-mono bg-gray-50 px-3 py-1 rounded border border-gray-200 inline-block">
                        {{ $veterinaria->rfc ?? '---' }}
                    </p>
                </div>
            </div>

        </div>

        <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 flex justify-between items-center">
            <a href="/" class="text-gray-500 hover:text-purple-600 font-bold transition flex items-center">
                &larr; Volver al Inicio
            </a>
            
            <a href="{{ route('veterinarias.edit') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition transform font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Editar Información
            </a>
        </div>
    </div>
</div>
@endsection