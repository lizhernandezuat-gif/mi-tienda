@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 border border-purple-100 flex flex-col md:flex-row">
        <div class="w-full md:w-1/3 bg-purple-50 flex items-center justify-center p-6 border-b md:border-b-0 md:border-r border-purple-100">
            @if($mascota->foto)
                <img src="{{ asset('storage/' . $mascota->foto) }}" class="h-40 w-40 rounded-full object-cover border-4 border-white shadow-lg">
            @else
                <div class="h-40 w-40 rounded-full bg-white border-4 border-purple-200 flex items-center justify-center text-6xl shadow-lg">🐾</div>
            @endif
        </div>
        
        <div class="w-full md:w-2/3 p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">{{ $mascota->nombre }}</h1>
                    <p class="text-purple-600 font-bold">{{ $mascota->especie }} - {{ $mascota->raza }}</p>
                </div>
                <a href="{{ route('clientes.show', $mascota->cliente_id) }}" class="text-gray-400 hover:text-gray-600 font-bold text-sm bg-gray-100 px-3 py-1 rounded-lg transition">
                    &larr; Volver al Dueño
                </a>
            </div>

            <form action="{{ route('vacunas.store', $mascota->id) }}" method="POST" class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                @csrf
                <p class="text-xs font-bold text-gray-500 uppercase mb-3">Registrar Nueva Dosis / Evento</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <input type="text" name="nombre" placeholder="Nombre (ej: Rabia)" required class="rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                    <input type="date" name="fecha_aplicacion" required class="rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                    <input type="date" name="proxima_aplicacion" title="Próxima Dosis (Opcional)" class="rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                </div>
                <div class="mt-3 text-right">
                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-2 rounded-lg font-bold text-sm hover:shadow-lg transition transform hover:-translate-y-0.5">
                        + Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <h2 class="text-2xl font-bold text-gray-800 mb-6 pl-2 border-l-4 border-purple-500">Historial Médico</h2>

    <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-300 before:to-transparent">
        
        @forelse($mascota->vacunas as $vacuna)
            @php
                // Lógica de Semáforo
                $estadoColor = 'bg-green-100 text-green-800 border-green-200';
                $icono = '✅';
                $mensaje = 'Vigente';

                if($vacuna->proxima_aplicacion) {
                    if($vacuna->proxima_aplicacion < now()) {
                        $estadoColor = 'bg-red-100 text-red-800 border-red-200';
                        $icono = '🔴';
                        $mensaje = 'Vencida';
                    } elseif($vacuna->proxima_aplicacion < now()->addMonth()) {
                        $estadoColor = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                        $icono = '⚠️';
                        $mensaje = 'Por vencer';
                    }
                }
            @endphp

            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-purple-100 text-xl shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow-purple-200">
                    💉
                </div>
                
                <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-4 rounded-xl border border-gray-100 shadow-md hover:shadow-xl transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">{{ $vacuna->nombre }}</h3>
                            <p class="text-sm text-gray-500">Aplicada: {{ $vacuna->fecha_aplicacion->format('d/m/Y') }}</p>
                        </div>
                        <form action="{{ route('vacunas.destroy', $vacuna->id) }}" method="POST" onsubmit="return confirm('¿Borrar registro?');">
                            @csrf @method('DELETE')
                            <button class="text-gray-300 hover:text-red-500 transition">✕</button>
                        </form>
                    </div>

                    @if($vacuna->proxima_aplicacion)
                        <div class="mt-3 flex items-center justify-between bg-gray-50 p-2 rounded-lg border {{ $estadoColor }} bg-opacity-30">
                            <span class="text-xs font-bold uppercase tracking-wider">Próxima Dosis:</span>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-sm">{{ $vacuna->proxima_aplicacion->format('d/m/Y') }}</span>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-white border shadow-sm">{{ $icono }} {{ $mensaje }}</span>
                            </div>
                        </div>
                    @else
                        <div class="mt-3 text-xs text-gray-400 italic">Dosis única / Sin recordatorio</div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-10">
                <p class="text-gray-400 text-lg">No hay historial registrado.</p>
                <p class="text-purple-500 text-sm">Usa el formulario de arriba para agregar la primera vacuna.</p>
            </div>
        @endforelse

    </div>
</div>
@endsection