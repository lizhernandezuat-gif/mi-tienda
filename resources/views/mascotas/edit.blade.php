@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-gray-900">Editar Paciente</h1>
        <a href="{{ route('clientes.show', $mascota->cliente_id) }}" class="text-purple-600 font-bold bg-purple-50 px-4 py-2 rounded-lg hover:bg-purple-100 transition flex items-center shadow-sm">
            &larr; Cancelar
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
        
        <div class="bg-gradient-to-r from-purple-600 to-pink-500 px-8 py-6 text-white">
            <h2 class="text-xl font-bold flex items-center gap-2">
                Editando a: {{ $mascota->nombre }}
            </h2>
            <p class="text-purple-100 text-sm mt-1">Dueño: {{ $mascota->cliente->nombre }}</p>
        </div>

        <form action="{{ route('mascotas.update', $mascota->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="flex flex-col md:flex-row gap-6 bg-purple-50 p-6 rounded-xl border border-purple-100">
                <div class="shrink-0 flex flex-col items-center">
                    @if($mascota->foto)
                        <img src="{{ asset('storage/' . $mascota->foto) }}" class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-md mb-2">
                    @else
                        <div class="h-24 w-24 rounded-full bg-white border-4 border-purple-200 flex items-center justify-center text-3xl shadow-sm mb-2">
                            🐾
                        </div>
                    @endif
                    <label class="block text-xs font-bold text-purple-600 uppercase">Cambiar Foto</label>
                </div>
                
                <div class="w-full space-y-4">
                    <div>
                        <input type="file" name="foto" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-white file:text-purple-700 hover:file:bg-purple-100 cursor-pointer">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Estado de Salud</label>
                        <select name="estado" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 py-2 px-3 font-bold text-gray-700">
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
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $mascota->nombre) }}" class="w-full rounded-lg border-gray-300 py-3 px-4 bg-gray-50 font-bold text-lg">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Especie</label>
                    <select name="especie" class="w-full rounded-lg border-gray-300 py-3 px-4 bg-white">
                        <option value="Perro" {{ $mascota->especie == 'Perro' ? 'selected' : '' }}>Perro 🐶</option>
                        <option value="Gato" {{ $mascota->especie == 'Gato' ? 'selected' : '' }}>Gato 🐱</option>
                        <option value="Ave" {{ $mascota->especie == 'Ave' ? 'selected' : '' }}>Ave 🐦</option>
                        <option value="Reptil" {{ $mascota->especie == 'Reptil' ? 'selected' : '' }}>Reptil 🦎</option>
                        <option value="Otro" {{ $mascota->especie == 'Otro' ? 'selected' : '' }}>Otro 🐾</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Raza</label>
                    <input type="text" name="raza" value="{{ old('raza', $mascota->raza) }}" class="w-full rounded-lg border-gray-300 py-3 px-4 bg-gray-50">
                </div>
            </div>

            <div class="bg-pink-50 p-6 rounded-xl border border-pink-100 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-pink-700 uppercase mb-1">Color</label>
                    <input type="text" name="color" value="{{ old('color', $mascota->color) }}" class="w-full rounded-lg border-pink-200 py-2 px-3 bg-white text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-pink-700 uppercase mb-1">Peso (Kg)</label>
                    <input type="number" step="0.01" name="peso" value="{{ old('peso', $mascota->peso) }}" class="w-full rounded-lg border-pink-200 py-2 px-3 bg-white text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-pink-700 uppercase mb-1">Edad</label>
                    <input type="number" name="edad" value="{{ old('edad', $mascota->edad) }}" class="w-full rounded-lg border-pink-200 py-2 px-3 bg-white text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Notas Médicas</label>
                <textarea name="notas_medicas" rows="3" class="w-full rounded-lg border-gray-300 py-3 px-4 bg-gray-50">{{ old('notas_medicas', $mascota->notas_medicas) }}</textarea>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-8 py-3 rounded-xl text-white font-bold bg-gradient-to-r from-purple-600 to-pink-600 hover:shadow-lg transform hover:-translate-y-0.5 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection