@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-gray-900">Nuevo Paciente</h1>
        <a href="{{ route('clientes.show', $cliente->id) }}" class="text-gray-700 font-bold bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 transition flex items-center shadow-sm">
            &larr; Volver
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
        
        {{-- Header dinámico --}}
        <div class="bg-custom-primary px-8 py-6 text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-white" style="mask-image: radial-gradient(circle, black, transparent);"></div>
            
            <div class="relative z-10">
                <h2 class="text-xl font-bold flex items-center gap-2" style="color: #ffffff; text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Dueño: {{ $cliente->nombre }}
                </h2>
                <p class="text-sm mt-1 ml-8" style="color: rgba(255,255,255,0.9); text-shadow: 0 1px 2px rgba(0,0,0,0.5);">Agregando una nueva mascota a su expediente.</p>
            </div>
        </div>

        <form action="{{ route('mascotas.store', $cliente->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            {{-- Sección de foto: Usamos bg-gray-50 --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 flex flex-col sm:flex-row items-center gap-6">
                <div class="shrink-0">
                    <div class="h-24 w-24 rounded-full bg-white border-4 border-gray-300 flex items-center justify-center text-gray-400 shadow-sm">
                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                </div>
                <div class="w-full">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Foto de Perfil (Opcional)</label>
                    <input type="file" name="foto" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-white file:text-gray-800 hover:file:bg-gray-100 file:shadow-sm file:cursor-pointer transition cursor-pointer border border-gray-300 rounded-full bg-white">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-bold text-gray-900 mb-1">Nombre del Paciente <span class="text-red-600">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-custom-primary focus:ring-custom-primary py-3 px-4 bg-white font-bold text-lg text-gray-900 placeholder-gray-400" placeholder="Ej: Firulais">
                    @error('nombre') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-1">Estado Actual <span class="text-red-600">*</span></label>
                    <div class="relative">
                        <select name="estado" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-custom-primary focus:ring-custom-primary py-3 px-4 font-bold text-gray-900 appearance-none bg-white cursor-pointer">
                            <option value="Sano">🟢 Sano / Alta</option>
                            <option value="En Tratamiento">🟡 En Tratamiento</option>
                            <option value="En Observación">🟠 En Observación</option>
                            <option value="Hospitalizado">🔴 Hospitalizado (Urgente)</option>
                            <option value="Fallecido">⚫ Fallecido</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-1">Especie <span class="text-red-600">*</span></label>
                    <select name="especie" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-custom-primary focus:ring-custom-primary py-3 px-4 border bg-white text-gray-900 font-medium cursor-pointer">
                        <option value="Perro">Perro 🐶</option>
                        <option value="Gato">Gato 🐱</option>
                        <option value="Ave">Ave 🐦</option>
                        <option value="Reptil">Reptil 🦎</option>
                        <option value="Otro">Otro 🐾</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-1">Raza</label>
                    <input type="text" name="raza" value="{{ old('raza') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-custom-primary focus:ring-custom-primary py-3 px-4 border bg-white text-gray-900 placeholder-gray-400" placeholder="Ej: Labrador">
                </div>
            </div>

            {{-- Bloque de detalles físicos: Usamos bg-gray-50 y colores neutros oscuros --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Color / Señas</label>
                    <input type="text" name="color" value="{{ old('color') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-custom-primary focus:ring-custom-primary py-2 px-3 border bg-white text-sm text-gray-900 placeholder-gray-400">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Peso (Kg)</label>
                    <input type="number" step="0.01" name="peso" value="{{ old('peso') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-custom-primary focus:ring-custom-primary py-2 px-3 border bg-white text-sm text-gray-900 placeholder-gray-400" placeholder="0.00">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Edad (Años)</label>
                    <input type="number" name="edad" value="{{ old('edad') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-custom-primary focus:ring-custom-primary py-2 px-3 border bg-white text-sm text-gray-900 placeholder-gray-400">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-900 mb-1">Notas Médicas</label>
                <textarea name="notas_medicas" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-custom-primary focus:ring-custom-primary py-3 px-4 border bg-white text-gray-900 placeholder-gray-400" placeholder="Alergias, padecimientos previos..."></textarea>
            </div>

            <div class="pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit" class="px-8 py-4 rounded-xl text-white font-black bg-custom-primary hover:brightness-110 shadow-lg transform hover:-translate-y-1 transition-all flex items-center gap-2 active:scale-95 border border-transparent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Registrar Paciente
                </button>
            </div>

        </form>
    </div>
</div>
@endsection