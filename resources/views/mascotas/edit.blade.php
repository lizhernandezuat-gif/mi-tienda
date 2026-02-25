@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-gray-900">Editar Paciente</h1>
        <a href="{{ route('clientes.show', $mascota->cliente_id) }}" class="text-gray-700 font-bold bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 transition flex items-center shadow-sm">
            &larr; Cancelar
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
        
        {{-- Header dinámico --}}
        <div class="bg-custom-primary px-8 py-6 text-white relative">
            <div class="absolute inset-0 opacity-10 bg-black/10"></div>
            <div class="relative z-10">
                <h2 class="text-xl font-bold flex items-center gap-2" style="color: #ffffff; text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Editando a: {{ $mascota->nombre }}
                </h2>
                <p class="text-sm mt-1" style="color: rgba(255,255,255,0.9); text-shadow: 0 1px 2px rgba(0,0,0,0.5);">Dueño: {{ $mascota->cliente->nombre }}</p>
            </div>
        </div>

        <form action="{{ route('mascotas.update', $mascota->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Bloque de Foto y Estado: Usamos bg-gray-50 neutro --}}
            <div class="flex flex-col md:flex-row gap-6 bg-gray-50 p-6 rounded-xl border border-gray-200">
                <div class="shrink-0 flex flex-col items-center">
                    @if($mascota->foto)
                        <img src="{{ asset('storage/' . $mascota->foto) }}" class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-md mb-2">
                    @else
                        <div class="h-24 w-24 rounded-full bg-white border-4 border-gray-300 flex items-center justify-center text-3xl shadow-sm mb-2 text-gray-400">
                            🐾
                        </div>
                    @endif
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-tighter mt-2">Nueva Foto</label>
                </div>
                
                <div class="w-full space-y-4">
                    <div>
                        <input type="file" name="foto" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-white file:text-gray-800 hover:file:bg-gray-100 cursor-pointer transition shadow-sm border border-gray-300 rounded-full">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-1">Estado de Salud</label>
                        <select name="estado" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-custom-primary focus:ring-custom-primary py-2 px-3 font-bold text-gray-900 cursor-pointer bg-white">
                            <option value="Sano" {{ $mascota->estado == 'Sano' ? 'selected' : '' }}>🟢 Sano / Alta</option>
                            <option value="En Tratamiento" {{ $mascota->estado == 'En Tratamiento' ? 'selected' : '' }}>🟡 En Tratamiento</option>
                            <option value="En Observación" {{ $mascota->estado == 'En Observación' ? 'selected' : '' }}>🟠 En Observación</option>
                            <option value="Hospitalizado" {{ $mascota->estado == 'Hospitalizado' ? 'selected' : '' }}>🔴 Hospitalizado</option>
                            <option value="Fallecido" {{ $mascota->estado == 'Fallecido' ? 'selected' : '' }}>⚫ Fallecido</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-sm font-bold text-gray-900 mb-1">Nombre del Paciente</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $mascota->nombre) }}" 
                           class="w-full rounded-lg border-gray-300 focus:ring-custom-primary focus:border-custom-primary py-3 px-4 bg-white font-bold text-lg text-gray-900 transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-1">Especie</label>
                    <select name="especie" class="w-full rounded-lg border-gray-300 focus:ring-custom-primary focus:border-custom-primary py-3 px-4 bg-white text-gray-900 font-medium cursor-pointer transition">
                        <option value="Perro" {{ $mascota->especie == 'Perro' ? 'selected' : '' }}>Perro 🐶</option>
                        <option value="Gato" {{ $mascota->especie == 'Gato' ? 'selected' : '' }}>Gato 🐱</option>
                        <option value="Ave" {{ $mascota->especie == 'Ave' ? 'selected' : '' }}>Ave 🐦</option>
                        <option value="Reptil" {{ $mascota->especie == 'Reptil' ? 'selected' : '' }}>Reptil 🦎</option>
                        <option value="Otro" {{ $mascota->especie == 'Otro' ? 'selected' : '' }}>Otro 🐾</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-1">Raza</label>
                    <input type="text" name="raza" value="{{ old('raza', $mascota->raza) }}" 
                           class="w-full rounded-lg border-gray-300 focus:ring-custom-primary focus:border-custom-primary py-3 px-4 bg-white text-gray-900 transition">
                </div>
            </div>

            {{-- Ficha técnica: Usamos bg-gray-50 y colores neutros oscuros --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Color / Señas</label>
                    <input type="text" name="color" value="{{ old('color', $mascota->color) }}" 
                           class="w-full rounded-lg border-gray-300 py-2 px-3 bg-white text-sm text-gray-900 focus:ring-custom-primary focus:border-custom-primary transition shadow-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Peso (Kg)</label>
                    <input type="number" step="0.01" name="peso" value="{{ old('peso', $mascota->peso) }}" 
                           class="w-full rounded-lg border-gray-300 py-2 px-3 bg-white text-sm text-gray-900 focus:ring-custom-primary focus:border-custom-primary transition shadow-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Edad (Años)</label>
                    <input type="number" name="edad" value="{{ old('edad', $mascota->edad) }}" 
                           class="w-full rounded-lg border-gray-300 py-2 px-3 bg-white text-sm text-gray-900 focus:ring-custom-primary focus:border-custom-primary transition shadow-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-900 mb-1">Notas Médicas / Historial Corto</label>
                <textarea name="notas_medicas" rows="3" 
                          class="w-full rounded-lg border-gray-300 focus:ring-custom-primary focus:border-custom-primary py-3 px-4 bg-white text-gray-900 transition">{{ old('notas_medicas', $mascota->notas_medicas) }}</textarea>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" 
                        class="px-10 py-4 rounded-xl text-white font-black bg-custom-primary shadow-lg hover:brightness-110 transform hover:-translate-y-1 transition-all flex items-center gap-2 active:scale-95 border border-transparent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Actualizar Ficha
                </button>
            </div>
        </form>
    </div>
</div>
@endsection