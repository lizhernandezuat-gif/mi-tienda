@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        
        <div class="bg-gray-50 px-8 py-6 flex justify-between items-center border-b border-gray-200">
            <div>
                <h2 class="text-2xl font-black text-gray-800">Detalles de la Cita</h2>
                <p class="text-gray-500 font-medium">Programada para el {{ $cita->fecha_hora_inicio->format('d \d\e F, Y') }}</p>
            </div>
            <div class="text-right">
                <span class="block text-3xl font-black text-purple-600">{{ $cita->fecha_hora_inicio->format('H:i') }}</span>
                @if($cita->estado == 'pendiente')
                    <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-bold mt-1">⏳ Pendiente</span>
                @elseif($cita->estado == 'confirmada')
                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-bold mt-1">👍 Confirmada</span>
                @elseif($cita->estado == 'completada')
                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold mt-1">✅ Completada</span>
                @else
                    <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-bold mt-1">❌ Cancelada</span>
                @endif
            </div>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Información del Cliente</h3>
                <div class="flex items-start gap-4 mb-6">
                    <div class="bg-purple-100 p-3 rounded-full text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-900">{{ $cita->cliente->nombre }}</p>
                        <p class="text-gray-500">{{ $cita->cliente->telefono ?? 'Sin teléfono' }}</p>
                    </div>
                </div>

                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Pacientes</h3>
                <div class="space-y-3">
                    @foreach($cita->mascotas as $mascota)
                        <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <span class="text-2xl">
                                {{ $mascota->especie == 'Perro' ? '🐶' : ($mascota->especie == 'Gato' ? '🐱' : '🐾') }}
                            </span>
                            <div>
                                <p class="font-bold text-gray-800">{{ $mascota->nombre }}</p>
                                <p class="text-xs text-gray-500">{{ $mascota->raza }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="border-l border-gray-100 md:pl-8">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Motivo</h3>
                <p class="text-xl font-medium text-gray-800 mb-8">"{{ $cita->motivo }}"</p>

                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Notas</h3>
                <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-100 text-gray-700 italic">
                    {{ $cita->notas_internas ?? 'Sin notas.' }}
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 flex justify-end">
            <a href="{{ route('citas.index') }}" class="text-gray-600 font-bold hover:text-gray-800 transition">← Volver</a>
        </div>
    </div>
</div>
@endsection