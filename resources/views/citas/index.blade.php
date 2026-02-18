@extends('layouts.app')

@section('titulo', 'Agenda de Citas')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Agenda Veterinaria</h2>
            <p class="text-gray-600">Administra los compromisos y urgencias del día.</p>
        </div>
        
        <a href="{{ route('citas.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-150 ease-in-out flex items-center gap-2 transform hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
            </svg>
            Agendar Nueva Cita
        </a>
    </div>

    <div class="space-y-4 mb-12">
        @forelse($citas as $cita)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row justify-between items-center hover:shadow-md transition duration-200 group relative overflow-hidden">
                
                <div class="absolute left-0 top-0 bottom-0 w-2 
                    {{ $cita->estado == 'pendiente' ? 'bg-orange-400' : 'bg-green-500' }}">
                </div>

                <div class="flex items-center gap-5 w-full md:w-1/3 pl-4">
                    <div class="text-center bg-gray-50 rounded-lg p-3 min-w-[80px]">
                        <span class="block text-xl font-extrabold text-gray-800">{{ $cita->fecha_hora_inicio->format('H:i') }}</span>
                        <span class="text-xs uppercase font-bold text-gray-500">{{ $cita->fecha_hora_inicio->format('M d') }}</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 group-hover:text-purple-600 transition">{{ $cita->motivo }}</h3>
                        @if($cita->estado === 'pendiente')
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                ⏳ Pendiente
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                ✅ Confirmada
                            </span>
                        @endif
                    </div>
                </div>

                <div class="w-full md:w-1/3 mt-4 md:mt-0 px-4">
                    <div class="flex flex-col gap-1">
                        <span class="text-sm text-gray-500 font-medium uppercase tracking-wider text-xs">Cliente & Pacientes</span>
                        <span class="text-gray-900 font-bold">{{ $cita->cliente->nombre }}</span>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($cita->mascotas as $mascota)
                                <span class="bg-purple-50 text-purple-700 text-xs px-2 py-1 rounded-md border border-purple-100 font-medium">
                                    🐾 {{ $mascota->nombre }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/3 mt-4 md:mt-0 flex justify-end items-center gap-3">
                    
                    <button class="flex items-center gap-2 bg-green-50 text-green-600 hover:bg-green-500 hover:text-white px-4 py-2 rounded-xl font-bold transition duration-200 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        Recordar
                    </button>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="bg-purple-50 rounded-full h-20 w-20 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Agenda Libre</h3>
                <p class="text-gray-500 mb-6">No hay citas programadas para hoy ni los próximos días.</p>
                <a href="{{ route('citas.create') }}" class="inline-block bg-purple-100 text-purple-700 font-bold py-2 px-6 rounded-full hover:bg-purple-200 transition">
                    + Programar la primera
                </a>
            </div>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $citas->links() }}
    </div>

</div>
@endsection