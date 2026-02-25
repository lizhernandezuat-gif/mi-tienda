@extends('layouts.app')

@section('titulo', 'Editar Cita')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-gray-800">Editar Cita</h2>
            <p class="text-gray-500">Modifica los detalles, horario o pacientes.</p>
        </div>
        <a href="{{ route('citas.index') }}" class="text-gray-500 hover:text-gray-900 font-bold transition-colors">← Volver/Cancelar</a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            {{-- 1. CLIENTE SELECCIONADO --}}
            <div class="mb-8 border-b border-gray-100 pb-8">
                <h3 class="text-gray-900 font-black uppercase tracking-widest text-xs mb-4">1. Propietario</h3>
                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200 flex items-center gap-4">
                    <div class="bg-white p-3 rounded-xl text-gray-500 shadow-sm border border-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <p class="font-black text-gray-900 text-lg leading-tight">{{ $cita->cliente->nombre }}</p>
                        <p class="text-sm text-gray-600 font-medium italic">📞 {{ $cita->cliente->telefono ?? 'Sin teléfono' }}</p>
                    </div>
                    <input type="hidden" name="cliente_id" value="{{ $cita->cliente_id }}">
                </div>
            </div>

            {{-- 2. PACIENTES --}}
            <div class="mb-8 border-b border-gray-100 pb-8">
                <div class="flex items-center gap-3 mb-5">
                    <h3 class="text-gray-900 font-black uppercase tracking-widest text-xs">2. Pacientes (Mascotas)</h3>
                    
                    <span id="badgeLimite" class="text-[10px] bg-gray-200 text-gray-800 px-3 py-1 rounded-full font-black uppercase tracking-tighter border border-gray-300 transition-all duration-300">
                        Máximo {{ $max_mascotas }}
                    </span>

                    <span id="mensajeError" class="hidden text-[10px] text-red-600 font-black uppercase flex items-center gap-1 animate-bounce">
                        ⚠️ ¡Límite alcanzado!
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($cita->cliente->mascotas as $mascota)
                        <label class="cursor-pointer relative group">
                            <input type="checkbox" name="mascotas[]" value="{{ $mascota->id }}" 
                                class="peer sr-only checkbox-mascota"
                                {{ $cita->mascotas->contains($mascota->id) ? 'checked' : '' }}>
                            
                            <div class="p-4 rounded-2xl border-2 border-gray-200 peer-checked:border-custom-primary peer-checked:bg-gray-50 hover:border-gray-300 transition-all flex items-center gap-3 select-none shadow-sm bg-white">
                                <span class="text-3xl filter grayscale peer-checked:grayscale-0 group-hover:grayscale-0 transition-all">
                                    {{ $mascota->especie == 'Perro' ? '🐶' : ($mascota->especie == 'Gato' ? '🐱' : '🐾') }}
                                </span>
                                <div>
                                    <span class="font-black text-gray-900 block leading-none">{{ $mascota->nombre }}</span>
                                    <span class="text-[10px] font-bold text-gray-500 uppercase">{{ $mascota->raza }}</span>
                                </div>
                                
                                <div class="ml-auto text-custom-primary opacity-0 peer-checked:opacity-100 transition-all transform scale-50 peer-checked:scale-100">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('mascotas') <p class="text-red-600 text-xs mt-3 font-black italic">{{ $message }}</p> @enderror
            </div>

            {{-- 3. FECHA Y MOTIVO --}}
            <div class="mb-8">
                <h3 class="text-gray-900 font-black uppercase tracking-widest text-xs mb-6">3. Fecha y Motivo</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Fecha <span class="text-red-600">*</span></label>
                        <input type="date" name="fecha" 
                               value="{{ old('fecha', $cita->fecha_hora_inicio->format('Y-m-d')) }}"
                               class="w-full rounded-2xl border-2 border-gray-200 focus:border-custom-primary focus:ring-0 transition-all p-3 outline-none text-gray-900 bg-white" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Hora <span class="text-red-600">*</span></label>
                        <input type="time" name="hora" 
                               value="{{ old('hora', $cita->fecha_hora_inicio->format('H:i')) }}"
                               class="w-full rounded-2xl border-2 border-gray-200 focus:border-custom-primary focus:ring-0 transition-all p-3 outline-none text-gray-900 bg-white" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Motivo de Consulta <span class="text-red-600">*</span></label>
                    <input type="text" name="motivo" 
                            value="{{ old('motivo', $cita->motivo) }}"
                            class="w-full rounded-2xl border-2 border-gray-200 focus:border-custom-primary focus:ring-0 transition-all p-3 outline-none font-medium text-gray-900 bg-white" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Estado Actual</label>
                    <select name="estado" class="w-full rounded-2xl border-2 border-gray-200 focus:border-custom-primary focus:ring-0 transition-all p-3 outline-none bg-white cursor-pointer font-bold text-gray-900">
                        <option value="pendiente" {{ $cita->estado == 'pendiente' ? 'selected' : '' }}>⏳ Pendiente</option>
                        <option value="confirmada" {{ $cita->estado == 'confirmada' ? 'selected' : '' }}>👍 Confirmada</option>
                        <option value="completada" {{ $cita->estado == 'completada' ? 'selected' : '' }}>✅ Completada</option>
                        <option value="cancelada" {{ $cita->estado == 'cancelada' ? 'selected' : '' }}>❌ Cancelada</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Notas Internas</label>
                    <textarea name="notas" rows="3" class="w-full rounded-2xl border-2 border-gray-200 focus:border-custom-primary focus:ring-0 transition-all p-4 outline-none text-gray-900 bg-white">{{ old('notas', $cita->notas_internas) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-8">
                <button type="submit" class="bg-custom-primary hover:brightness-110 text-white font-black py-4 px-10 rounded-2xl shadow-xl transition transform hover:-translate-y-1 active:scale-95 flex items-center gap-2 border border-transparent">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Actualizar Cita
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.checkbox-mascota');
        const maxMascotas = {{ $max_mascotas }};
        const badge = document.getElementById('badgeLimite');
        const errorMsg = document.getElementById('mensajeError');

        checkboxes.forEach(box => {
            box.addEventListener('change', function() {
                const marcados = document.querySelectorAll('.checkbox-mascota:checked');
                if (marcados.length > maxMascotas) {
                    this.checked = false;
                    badge.classList.remove('bg-gray-200', 'text-gray-800');
                    badge.classList.add('bg-red-100', 'text-red-700');
                    errorMsg.classList.remove('hidden');
                    setTimeout(() => {
                        badge.classList.remove('bg-red-100', 'text-red-700');
                        badge.classList.add('bg-gray-200', 'text-gray-800');
                        errorMsg.classList.add('hidden');
                    }, 3000);
                }
            });
        });
    });
</script>
@endsection