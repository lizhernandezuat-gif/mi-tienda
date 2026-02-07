@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-gray-900">Configuración del Negocio</h1>
        <a href="{{ route('veterinarias.show') }}" class="text-purple-600 hover:text-purple-900 font-bold bg-purple-50 hover:bg-purple-100 px-4 py-2 rounded-lg transition flex items-center shadow-sm">
            &larr; Cancelar
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-8 text-white flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight">Editar Información</h2>
                <p class="text-purple-100 mt-1 text-sm">Actualiza los datos públicos de tu veterinaria.</p>
            </div>
            <div class="h-14 w-14 bg-white/20 backdrop-blur-sm text-white rounded-full flex items-center justify-center shadow-inner border border-white/30">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </div>
        </div>

        <form action="{{ route('veterinarias.update') }}" method="POST" class="p-8">
            @csrf
            @method('PUT') 
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="space-y-6">
                    <h3 class="text-purple-600 font-bold text-sm uppercase tracking-wider border-b border-purple-100 pb-2">Identidad</h3>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nombre del Negocio <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre', $veterinaria->nombre) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50">
                        @error('nombre') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Slogan</label>
                        <input type="text" name="slogan" value="{{ old('slogan', $veterinaria->slogan) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">RFC / Registro</label>
                        <input type="text" name="rfc" value="{{ old('rfc', $veterinaria->rfc) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50">
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-pink-600 font-bold text-sm uppercase tracking-wider border-b border-pink-100 pb-2">Contacto</h3>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Teléfono <span class="text-red-500">*</span></label>
                        <input type="text" name="telefono" value="{{ old('telefono', $veterinaria->telefono) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50">
                        @error('telefono') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Dirección Completa <span class="text-red-500">*</span></label>
                        <input type="text" name="direccion" value="{{ old('direccion', $veterinaria->direccion) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Horario de Atención</label>
                        <input type="text" name="horario" value="{{ old('horario', $veterinaria->horario) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 px-4 border bg-gray-50" placeholder="Ej: Lun-Vie 9am - 6pm">
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-8 py-3 rounded-xl text-white font-bold bg-gradient-to-r from-purple-600 to-pink-600 hover:shadow-lg hover:from-purple-700 hover:to-pink-700 transform hover:-translate-y-0.5 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Guardar Cambios
                </button>
            </div>

        </form>
    </div>
</div>
@endsection