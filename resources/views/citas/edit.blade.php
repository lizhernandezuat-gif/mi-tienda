@extends('layouts.app')

@section('titulo', 'Editar Cita')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-gray-800">Editar Cita</h2>
            <p class="text-gray-500">Modifica los detalles, horario o pacientes.</p>
        </div>
        <a href="{{ route('citas.index') }}" class="text-gray-500 hover:text-gray-700 font-bold">← Volver/Cancelar</a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <div class="mb-8 border-b border-gray-100 pb-8">
                <h3 class="text-purple-600 font-bold uppercase tracking-wider text-xs mb-4">1. Cliente Seleccionado</h3>
                <div class="bg-purple-50 p-4 rounded-xl border border-purple-100 flex items-center gap-4">
                    <div class="bg-white p-3 rounded-full text-purple-600 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 text-lg">{{ $cita->cliente->nombre }}</p>
                        <p class="text-sm text-gray-500">{{ $cita->cliente->telefono ?? 'Sin teléfono' }}</p>
                    </div>
                    <input type="hidden" name="cliente_id" value="{{ $cita->cliente_id }}">
                </div>
            </div>

            <div class="mb-8 border-b border-gray-100 pb-8">
                <div class="flex items-center gap-3 mb-4">
                    <h3 class="text-purple-600 font-bold uppercase tracking-wider text-xs">2. Pacientes (Mascotas)</h3>
                    
                    <span id="badgeLimite" class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-bold transition-all duration-300">
                        Máximo {{ $max_mascotas }}
                    </span>

                    <span id="mensajeError" class="hidden text-xs text-red-500 font-bold flex items-center gap-1 animate-bounce">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        ¡Límite alcanzado!
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($cita->cliente->mascotas as $mascota)
                        <label class="cursor-pointer relative">
                            <input type="checkbox" name="mascotas[]" value="{{ $mascota->id }}" 
                                class="peer sr-only checkbox-mascota"
                                {{ $cita->mascotas->contains($mascota->id) ? 'checked' : '' }}>
                            
                            <div class="p-4 rounded-xl border-2 border-gray-100 peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:bg-gray-50 transition flex items-center gap-3 select-none">
                                <span class="text-2xl">{{ $mascota->especie == 'Perro' ? '🐶' : ($mascota->especie == 'Gato' ? '🐱' : '🐾') }}</span>
                                <div>
                                    <span class="font-bold text-gray-800 block">{{ $mascota->nombre }}</span>
                                    <span class="text-xs text-gray-500">{{ $mascota->raza }}</span>
                                </div>
                                
                                <div class="ml-auto text-purple-600 opacity-0 peer-checked:opacity-100 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('mascotas') <p class="text-red-500 text-sm mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="mb-8">
                <h3 class="text-purple-600 font-bold uppercase tracking-wider text-xs mb-4">3. Fecha y Motivo</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Fecha</label>
                        <input type="date" name="fecha" 
                               value="{{ old('fecha', $cita->fecha_hora_inicio->format('Y-m-d')) }}"
                               class="w-full rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Hora</label>
                        <input type="time" name="hora" 
                               value="{{ old('hora', $cita->fecha_hora_inicio->format('H:i')) }}"
                               class="w-full rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Motivo de Consulta</label>
                    <input type="text" name="motivo" 
                           value="{{ old('motivo', $cita->motivo) }}"
                           class="w-full rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Estado Actual</label>
                    <select name="estado" class="w-full rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm">
                        <option value="pendiente" {{ $cita->estado == 'pendiente' ? 'selected' : '' }}>⏳ Pendiente</option>
                        <option value="confirmada" {{ $cita->estado == 'confirmada' ? 'selected' : '' }}>👍 Confirmada</option>
                        <option value="completada" {{ $cita->estado == 'completada' ? 'selected' : '' }}>✅ Completada</option>
                        <option value="cancelada" {{ $cita->estado == 'cancelada' ? 'selected' : '' }}>❌ Cancelada</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Notas Internas</label>
                    <textarea name="notas" rows="3" class="w-full rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 shadow-sm">{{ old('notas', $cita->notas_internas) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition hover:scale-105">
                    💾 Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.checkbox-mascota');
        const maxMascotas = {{ $max_mascotas }};
        
        // Elementos visuales
        const badge = document.getElementById('badgeLimite');
        const errorMsg = document.getElementById('mensajeError');

        checkboxes.forEach(box => {
            box.addEventListener('change', function() {
                const marcados = document.querySelectorAll('.checkbox-mascota:checked');
                
                // Si intenta marcar más del límite
                if (marcados.length > maxMascotas) {
                    this.checked = false; // Desmarcamos suavemente
                    
                    // 1. Cambiamos el estilo del Badge a ROJO
                    badge.classList.remove('bg-blue-100', 'text-blue-700');
                    badge.classList.add('bg-red-100', 'text-red-700');
                    
                    // 2. Mostramos el mensaje de error interno
                    errorMsg.classList.remove('hidden');
                    
                    // 3. Después de 3 segundos, volvemos a la normalidad
                    setTimeout(() => {
                        badge.classList.remove('bg-red-100', 'text-red-700');
                        badge.classList.add('bg-blue-100', 'text-blue-700');
                        errorMsg.classList.add('hidden');
                    }, 3000);
                }
            });
        });
    });
</script>
@endsection