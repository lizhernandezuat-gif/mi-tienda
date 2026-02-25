@extends('layouts.app')

@section('titulo', 'Configuración del Sistema')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        
        {{-- Header: Quitamos el 'to-indigo-600' para que el color primario mande --}}
        <div class="bg-custom-primary p-8 relative overflow-hidden">
            {{-- Añadimos un patrón sutil para dar textura sin empañar el texto --}}
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
            
            <div class="relative z-10">
                <h2 class="text-3xl font-black text-white">Ajustes de la Veterinaria</h2>
                {{-- CAMBIO: text-white/80 para asegurar legibilidad sobre cualquier color --}}
                <p class="text-white/80 mt-1 font-medium italic">Personaliza tu agenda y la identidad de tu negocio.</p>
            </div>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" class="p-8 space-y-8">
            @csrf
            @method('PUT')

            <section>
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2 mb-6 uppercase tracking-wider">
                    <span class="p-2 bg-custom-light rounded-lg text-custom-primary">🎨</span> 
                    Identidad Visual
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Color Principal del Sistema</label>
                        <div class="flex items-center gap-4">
                            <input type="color" name="primary_color" value="{{ $settings->primary_color }}" 
                                   class="h-14 w-20 rounded-xl cursor-pointer border-2 border-white shadow-sm">
                            <span class="text-xs text-gray-500 font-mono bg-white px-3 py-1 rounded-md border border-gray-200">
                                {{ strtoupper($settings->primary_color) }}
                            </span>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-2 italic">* Este color cambiará botones, encabezados y detalles de todo el sitio.</p>
                    </div>

                    <div class="flex items-center justify-center bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="dark_mode" value="1" {{ $settings->dark_mode ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-custom-primary"></div>
                            <span class="ml-3 text-sm font-bold text-gray-600 uppercase tracking-tighter">Modo Noche</span>
                        </label>
                    </div>
                </div>
            </section>

            <hr class="border-gray-100">

            <section>
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2 mb-6 uppercase tracking-wider">
                    <span class="p-2 bg-custom-light rounded-lg text-custom-primary">⏰</span> 
                    Reglas de la Agenda
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Máximo de Mascotas por Cita</label>
                        <input type="number" name="max_mascotas_por_cita" value="{{ $settings->max_mascotas_por_cita }}" 
                               class="w-full rounded-xl border-gray-200 p-3 focus:ring-2 focus:ring-custom-primary/20 focus:border-custom-primary shadow-sm outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Duración estimada (minutos)</label>
                        <input type="number" name="duracion_cita_minutos" value="{{ $settings->duracion_cita_minutos }}" 
                               class="w-full rounded-xl border-gray-200 p-3 focus:ring-2 focus:ring-custom-primary/20 focus:border-custom-primary shadow-sm outline-none transition-all">
                    </div>
                </div>
            </section>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-custom-primary hover:brightness-110 text-white font-black py-4 px-10 rounded-2xl shadow-xl transition transform hover:-translate-y-1 active:scale-95 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Guardar Configuración
                </button>
            </div>
        </form>
    </div>
</div>
@endsection