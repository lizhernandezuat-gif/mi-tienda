@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-800">Directorio de Clientes</h2>
            <p class="text-gray-500 font-medium">Gestiona la base de datos de propietarios y pacientes.</p>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            {{-- Botón de Logout sutil --}}
            <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-500 font-bold px-4 py-2 transition-all text-sm">
                    Cerrar Sesión
                </button>
            </form>

            <a href="{{ route('clientes.create') }}" 
               class="w-full md:w-auto bg-custom-primary hover:brightness-110 text-white font-black py-3 px-6 rounded-2xl shadow-xl transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Cliente
            </a>
        </div>
    </div>

    {{-- Buscador Dinámico --}}
    <div class="mb-8">
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                <svg id="icon-search" class="h-6 w-6 text-gray-400 group-focus-within:text-custom-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <svg id="spinner" class="hidden animate-spin h-6 w-6 text-custom-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <input type="text" id="input-buscador" name="search" value="{{ request('search') }}" 
                class="block w-full pl-14 pr-6 py-5 border-2 border-gray-100 rounded-3xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:border-custom-primary focus:ring-4 focus:ring-custom-primary/10 text-xl shadow-sm transition-all" 
                placeholder="Buscar por nombre o teléfono..." autocomplete="off">
            
            @if(request('search'))
                <button onclick="window.location.href='{{ route('clientes.index') }}'" class="absolute inset-y-0 right-0 pr-6 flex items-center text-red-400 hover:text-red-600 transition">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                </button>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-8 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Propietario</th>
                        <th class="px-8 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Pacientes</th>
                        <th class="px-8 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Contacto</th>
                        <th class="px-8 py-5 text-right text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Gestión</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($clientes as $cliente)
                    <tr class="hover:bg-custom-light/30 transition-all group">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center">
                                {{-- Círculo con inicial dinámico --}}
                                <div class="flex-shrink-0 h-12 w-12">
                                    <div class="h-12 w-12 rounded-2xl bg-custom-primary flex items-center justify-center text-white font-black text-xl shadow-lg shadow-custom-primary/20 group-hover:rotate-6 transition-all duration-300">
                                        {{ substr($cliente->nombre, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-lg font-bold text-gray-900 group-hover:text-custom-primary transition-colors">
                                        @if(request('search'))
                                            {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<span class="bg-custom-primary/10 text-custom-primary px-1 rounded">$1</span>', $cliente->nombre) !!}
                                        @else
                                            {{ $cliente->nombre }}
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-400 font-medium">{{ $cliente->email ?? 'Sin email' }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-6 whitespace-nowrap">
                            @if($cliente->mascotas->count() > 0)
                                <div class="flex items-center gap-2">
                                    @foreach($cliente->mascotas->take(3) as $mascota)
                                        <div class="group/pet relative">
                                            <span class="text-3xl filter grayscale group-hover/pet:grayscale-0 transition-all cursor-help" title="{{ $mascota->nombre }}">
                                                @switch($mascota->especie)
                                                    @case('Perro') 🐶 @break
                                                    @case('Gato') 🐱 @break
                                                    @case('Ave') 🐦 @break
                                                    @default 🐾
                                                @endswitch
                                            </span>
                                        </div>
                                    @endforeach
                                    @if($cliente->mascotas->count() > 3)
                                        <span class="bg-custom-light text-custom-primary text-[10px] font-black rounded-lg h-8 w-8 flex items-center justify-center border border-custom-primary/10">
                                            +{{ $cliente->mascotas->count() - 3 }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-xs font-bold text-gray-300 italic uppercase">Sin registros</span>
                            @endif
                        </td>

                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center gap-2 text-gray-600 font-bold bg-gray-50 px-4 py-2 rounded-xl border border-gray-100 w-fit">
                                <svg class="w-4 h-4 text-custom-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $cliente->telefono }}
                            </div>
                        </td>

                        <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('clientes.show', $cliente->id) }}" 
                                   class="p-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-custom-primary hover:text-white transition-all shadow-sm border border-gray-200" title="Ver ficha">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                 </svg>
                                  </a>
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="p-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition-all shadow-sm" title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar cliente?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Eliminar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center justify-center opacity-40">
                                <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <p class="text-xl font-black text-gray-500 italic uppercase">Sin resultados</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-8 mb-20">
        {{ $clientes->appends(['search' => request('search')])->links() }} 
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let timeout = null;
        const input = document.getElementById('input-buscador');
        const spinner = document.getElementById('spinner');
        const icon = document.getElementById('icon-search');

        input.addEventListener('input', function() {
            clearTimeout(timeout);
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');

            timeout = setTimeout(() => {
                const query = input.value;
                window.location.href = "{{ route('clientes.index') }}?search=" + encodeURIComponent(query);
            }, 700); 
        });

        if (input.value.length > 0) {
            input.focus();
            input.setSelectionRange(input.value.length, input.value.length);
        }
    });
</script>
@endsection