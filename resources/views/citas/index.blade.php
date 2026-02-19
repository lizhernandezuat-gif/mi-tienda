@extends('layouts.app')

@section('titulo', 'Agenda de Citas')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Agenda Veterinaria</h2>
            <p class="text-gray-600">Gestión de pacientes y agenda.</p>
        </div>
        
        <a href="{{ route('citas.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-150 ease-in-out flex items-center gap-2 transform hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
            </svg>
            Agendar Cita
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-orange-400 flex items-center justify-between transition hover:shadow-md relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-orange-500 text-xs font-extrabold uppercase tracking-wider flex items-center gap-1">
                    ⚠️ Por Confirmar / Enviar WhatsApp
                </p>
                <h3 class="text-4xl font-black text-gray-800 mt-2">{{ $estadisticas['por_confirmar'] }}</h3>
                <p class="text-xs text-gray-400 mt-1">Pacientes pendientes</p>
            </div>
            <div class="bg-orange-50 p-4 rounded-full text-orange-500 group-hover:scale-110 transition duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-blue-500 flex items-center justify-between transition hover:shadow-md group">
            <div>
                <p class="text-blue-500 text-xs font-extrabold uppercase tracking-wider">🗓️ Agenda Confirmada</p>
                <h3 class="text-4xl font-black text-gray-800 mt-2">{{ $estadisticas['confirmadas_proximas'] }}</h3>
                <p class="text-xs text-gray-400 mt-1">Listos para llegar</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-full text-blue-500 group-hover:scale-110 transition duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-green-500 flex items-center justify-between transition hover:shadow-md group">
            <div>
                <p class="text-green-600 text-xs font-extrabold uppercase tracking-wider">✅ Finalizadas Hoy</p>
                <h3 class="text-4xl font-black text-gray-800 mt-2">{{ $estadisticas['atendidas_hoy'] }}</h3>
                <p class="text-xs text-gray-400 mt-1">Consultas completadas</p>
            </div>
            <div class="bg-green-50 p-4 rounded-full text-green-600 group-hover:scale-110 transition duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        
        <div class="flex space-x-1 rounded-xl bg-gray-200 p-1 w-full md:w-auto">
            <a href="{{ route('citas.index') }}" 
               class="flex-1 md:flex-none rounded-lg py-2.5 px-6 text-sm font-medium leading-5 text-center transition {{ !request('ver') ? 'bg-white text-purple-700 shadow' : 'text-gray-600 hover:bg-white/[0.12] hover:text-purple-600' }}">
                📅 Próximas
            </a>
            <a href="{{ route('citas.index', ['ver' => 'historial']) }}" 
               class="flex-1 md:flex-none rounded-lg py-2.5 px-6 text-sm font-medium leading-5 text-center transition {{ request('ver') == 'historial' ? 'bg-white text-purple-700 shadow' : 'text-gray-600 hover:bg-white/[0.12] hover:text-purple-600' }}">
                📜 Historial
            </a>
        </div>

        <form action="{{ route('citas.index') }}" method="GET" class="w-full md:w-1/3 relative">
            @if(request('ver'))
                <input type="hidden" name="ver" value="{{ request('ver') }}">
            @endif
            
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 sm:text-sm transition" 
                   placeholder="Buscar cliente, mascota o motivo...">
            
            @if(request('search'))
                <a href="{{ route('citas.index', ['ver' => request('ver')]) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif
        </form>
    </div>

    <div class="space-y-4 mb-12">
        @forelse($citas as $cita)
            <div class="bg-white rounded-2xl shadow-sm border p-6 flex flex-col md:flex-row justify-between items-center hover:shadow-md transition duration-200 group relative overflow-hidden
                {{-- LÓGICA DE URGENCIA: Si falta menos de 15 min o pasaron menos de 10 min --}}
                @if($cita->estado != 'completada' && $cita->estado != 'cancelada' && 
               $cita->fecha_hora_inicio->isToday() && 
                $cita->fecha_hora_inicio->diffInMinutes($ahora, false) >= -15 && 
                  $cita->fecha_hora_inicio->diffInMinutes($ahora, false) <= 10)
                border-red-400 ring-2 ring-red-100 animate-pulse
                  @else
           border-gray-100
              @endif">
                <div class="absolute left-0 top-0 bottom-0 w-2 
                    @if($cita->estado == 'pendiente') bg-yellow-400 
                    @elseif($cita->estado == 'confirmada') bg-blue-500
                    @elseif($cita->estado == 'completada') bg-green-500 
                    @else bg-gray-400 @endif">
                </div>

                <div class="flex items-center gap-5 w-full md:w-1/3 pl-4">
                    <div class="text-center bg-gray-50 rounded-lg p-3 min-w-[80px]">
                        <span class="block text-xl font-extrabold text-gray-800">{{ $cita->fecha_hora_inicio->format('H:i') }}</span>
                        <span class="text-xs uppercase font-bold text-gray-500">{{ $cita->fecha_hora_inicio->format('M d') }}</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 group-hover:text-purple-600 transition">
    {{ $cita->motivo }}
    
    @if($cita->estado != 'completada' && $cita->estado != 'cancelada' && 
        $cita->fecha_hora_inicio->isToday() && 
        $cita->fecha_hora_inicio->diffInMinutes($ahora, false) >= -15 && 
        $cita->fecha_hora_inicio->diffInMinutes($ahora, false) <= 10)
        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black bg-red-600 text-white uppercase tracking-tighter animate-bounce">
            ⏰ ¡Llegando!
        </span>
    @endif
</h3>
                        
                        @if($cita->estado === 'pendiente')
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">⏳ Pendiente</span>
                        @elseif($cita->estado === 'confirmada')
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">👍 Confirmada</span>
                        @elseif($cita->estado === 'completada')
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">✅ Completada</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">❌ Cancelada</span>
                        @endif
                    </div>
                </div>

                <div class="w-full md:w-1/3 mt-4 md:mt-0 px-4 border-l border-gray-50">
                    <div class="flex flex-col gap-1">
                        <span class="text-sm text-gray-500 font-medium uppercase tracking-wider text-[10px]">Cliente & Pacientes</span>
                        <span class="text-gray-900 font-bold">{{ $cita->cliente->nombre }}</span>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($cita->mascotas as $mascota)
                                <span class="bg-purple-50 text-purple-700 text-[11px] px-2 py-1 rounded-md border border-purple-100 font-medium flex items-center gap-1">
                                    {{ $mascota->especie == 'Perro' ? '🐶' : ($mascota->especie == 'Gato' ? '🐱' : '🐾') }}
                                    {{ $mascota->nombre }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/3 mt-4 md:mt-0 flex justify-end items-center gap-2">
                    
                    @if($cita->enlace_whatsapp)
                        <a href="{{ $cita->enlace_whatsapp }}" target="_blank" class="flex items-center gap-2 bg-green-50 text-green-600 hover:bg-green-500 hover:text-white px-3 py-2 rounded-xl font-bold transition duration-200 text-sm border border-green-100" title="WhatsApp">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg></a>
                        <button onclick="mostrarModalCopia(this)" data-mensaje="{{ $cita->mensaje_whatsapp }}" class="flex items-center gap-2 bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-900 px-3 py-2 rounded-xl font-bold transition duration-200 text-sm border border-green-100" title="Copiar"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg></button>
                    @endif

                    <a href="{{ route('citas.show', $cita->id) }}" class="p-2 text-gray-400 hover:text-purple-600 transition bg-white rounded-lg hover:bg-purple-50" title="Ver Detalles"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></a>

                    <a href="{{ route('citas.edit', $cita->id) }}" class="p-2 text-gray-400 hover:text-blue-600 transition bg-white rounded-lg hover:bg-blue-50" title="Editar"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></a>

                    @if($cita->estado == 'pendiente')
                        <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="inline">
                            @csrf @method('PUT') <input type="hidden" name="estado" value="confirmada">
                            <button type="button" onclick="confirmarAccion(this, '¿Confirmar asistencia?')" class="p-2 text-blue-400 hover:text-blue-600 transition bg-blue-50 rounded-lg hover:bg-blue-100" title="Confirmar"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></button>
                        </form>
                    
                    @elseif($cita->estado == 'confirmada')
                        <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="inline">
                            @csrf @method('PUT') <input type="hidden" name="estado" value="pendiente">
                            <button type="button" onclick="confirmarAccion(this, '¿Volver a Pendiente?')" class="p-2 text-yellow-500 hover:text-yellow-700 transition bg-yellow-50 rounded-lg hover:bg-yellow-100" title="Volver a Pendiente"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg></button>
                        </form>
                        <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="inline ml-1">
                            @csrf @method('PUT') <input type="hidden" name="estado" value="completada">
                            <button type="button" onclick="confirmarAccion(this, '¿Finalizar Cita?')" class="p-2 text-green-400 hover:text-green-600 transition bg-green-50 rounded-lg hover:bg-green-100" title="Completar"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></button>
                        </form>

                    @elseif($cita->estado == 'completada')
                        <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="inline">
                            @csrf @method('PUT') <input type="hidden" name="estado" value="confirmada">
                            <button type="button" onclick="confirmarAccion(this, 'Reactivar como Confirmada')" class="p-2 text-yellow-500 hover:text-yellow-700 transition bg-yellow-50 rounded-lg hover:bg-yellow-100" title="Deshacer"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg></button>
                        </form>

                    @elseif($cita->estado == 'cancelada')
                        <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="inline">
                            @csrf @method('PUT') <input type="hidden" name="estado" value="pendiente">
                            <button type="button" onclick="confirmarAccion(this, '¿Reactivar Cita?')" class="p-2 text-indigo-400 hover:text-indigo-600 transition bg-indigo-50 rounded-lg hover:bg-indigo-100" title="Reactivar"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg></button>
                        </form>
                    @endif

                    @if(!in_array($cita->estado, ['completada', 'cancelada']))
                        <form action="{{ route('citas.update', $cita->id) }}" method="POST" class="inline ml-1">
                            @csrf @method('PUT') <input type="hidden" name="estado" value="cancelada">
                            <button type="button" onclick="confirmarAccion(this, '¿Cancelar Cita?')" class="p-2 text-gray-300 hover:text-red-500 transition hover:bg-red-50 rounded-lg" title="Cancelar"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                        </form>
                    @endif

                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <p class="text-gray-500 mb-6">No hay citas en esta vista.</p>
                <a href="{{ route('citas.create') }}" class="inline-block bg-purple-100 text-purple-700 font-bold py-2 px-6 rounded-full hover:bg-purple-200 transition">
                    + Programar Cita
                </a>
            </div>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $citas->appends(request()->query())->links() }}
    </div>

</div>

<div id="modalCopia" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-lg mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Copiar Mensaje</h3>
            <button onclick="document.getElementById('modalCopia').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">✕</button>
        </div>
        <p class="text-sm text-gray-500 mb-2">Copia este texto (Ctrl+C) y pégalo donde quieras:</p>
        <textarea id="textoParaCopiar" class="w-full h-40 p-4 border border-gray-300 rounded-xl text-gray-800 text-sm focus:ring-purple-500 focus:border-purple-500 mb-4 bg-gray-50 font-mono" readonly></textarea>
        <div class="flex justify-end">
            <button onclick="document.getElementById('modalCopia').classList.add('hidden')" class="bg-purple-600 text-white font-bold py-2 px-6 rounded-xl hover:bg-purple-700">Cerrar</button>
        </div>
    </div>
</div>

<div id="modalConfirmacion" class="fixed inset-0 bg-gray-900 bg-opacity-60 hidden flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4 transform transition-all scale-100">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-lg leading-6 font-bold text-gray-900" id="tituloConfirmacion">¿Estás seguro?</h3>
            <div class="mt-2">
                <p class="text-sm text-gray-500" id="textoConfirmacion">Acción irreversible.</p>
            </div>
        </div>
        <div class="mt-6 flex justify-center gap-3">
            <button onclick="document.getElementById('modalConfirmacion').classList.add('hidden')" type="button" class="bg-white text-gray-700 hover:bg-gray-50 font-bold py-2 px-4 rounded-xl border border-gray-300 shadow-sm transition">Cancelar</button>
            <button onclick="ejecutarAccion()" type="button" class="bg-purple-600 text-white hover:bg-purple-700 font-bold py-2 px-4 rounded-xl shadow-lg transition">Sí, confirmar</button>
        </div>
    </div>
</div>

<script>
    function mostrarModalCopia(boton) {
        const modal = document.getElementById('modalCopia');
        const textArea = document.getElementById('textoParaCopiar');
        textArea.value = boton.getAttribute('data-mensaje');
        modal.classList.remove('hidden');
        textArea.select();
    }

    let formularioPendiente = null;
    function confirmarAccion(boton, mensaje) {
        formularioPendiente = boton.closest('form');
        document.getElementById('textoConfirmacion').innerText = mensaje;
        document.getElementById('modalConfirmacion').classList.remove('hidden');
    }
    function ejecutarAccion() {
        if (formularioPendiente) formularioPendiente.submit();
    }
</script>
@endsection