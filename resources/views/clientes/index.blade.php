
@extends('layouts.app')

@section('content')



<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Lista de Clientes</h2>
        <p class="text-gray-600">Administra a tus pacientes y sus dueños.</p>
    </div>

    <div class="flex items-center gap-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-500 hover:text-red-700 font-medium border border-red-200 hover:border-red-400 bg-white px-4 py-2 rounded-lg transition duration-150 ease-in-out">
                Cerrar Sesión
            </button>
        </form>

        <a href="{{ route('clientes.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-full shadow-lg transition duration-150 ease-in-out flex items-center">
            + Nuevo Cliente
        </a>
    </div>
</div>

    <div class="mb-8">
        <form action="{{ route('clientes.index') }}" method="GET" class="relative">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="block w-full pl-10 pr-20 py-4 border border-gray-200 rounded-2xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:placeholder-gray-300 focus:border-purple-500 focus:ring-purple-500 sm:text-lg shadow-sm transition" 
                    placeholder=" Escribe un nombre o teléfono y presiona Enter..." autocomplete="off">
                
                <button type="submit" class="absolute inset-y-2 right-2 px-6 bg-purple-100 text-purple-700 font-bold rounded-xl hover:bg-purple-200 transition">
                    Buscar
                </button>
            </div>
            @if(request('search'))
                <div class="mt-2 flex justify-between items-center px-2">
                    <p class="text-sm text-gray-500">Mostrando resultados para: <span class="font-bold text-gray-900">"{{ request('search') }}"</span></p>
                    <a href="{{ route('clientes.index') }}" class="text-sm text-red-500 hover:text-red-700 font-bold hover:underline">Limpiar filtro ✕</a>
                </div>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pacientes</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($clientes as $cliente)
                    <tr class="hover:bg-purple-50 transition duration-150 group">
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center text-white font-bold text-lg shadow-sm group-hover:scale-110 transition">
                                        {{ substr($cliente->nombre, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $cliente->nombre }}</div>
                                    <div class="text-xs text-gray-500">{{ $cliente->email ?? 'Sin correo' }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($cliente->mascotas->count() > 0)
                                <div class="flex items-center gap-1 cursor-help" title="Pacientes: {{ $cliente->mascotas->pluck('nombre')->implode(', ') }}">
                                    @foreach($cliente->mascotas->take(3) as $mascota)
                                        <span class="text-2xl hover:scale-125 transition inline-block">
                                            @switch($mascota->especie)
                                                @case('Perro') 🐶 @break
                                                @case('Gato') 🐱 @break
                                                @case('Ave') 🐦 @break
                                                @case('Reptil') 🦎 @break
                                                @default 🐾
                                            @endswitch
                                        </span>
                                    @endforeach
                                    @if($cliente->mascotas->count() > 3)
                                        <span class="bg-gray-100 text-purple-600 text-xs font-bold rounded-full h-7 w-7 flex items-center justify-center border border-gray-200">+{{ $cliente->mascotas->count() - 3 }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-400 border border-gray-200">Sin pacientes</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                            {{ $cliente->telefono }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-2 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <a href="{{ route('clientes.show', $cliente->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-md font-bold">Ver</a>
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="text-yellow-600 hover:text-yellow-900 bg-yellow-50 px-3 py-1 rounded-md font-bold">Editar</a>
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar cliente?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded-md font-bold">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <p class="text-lg font-medium text-gray-500">
                                    @if(request('search'))
                                        No encontramos coincidencias para "{{ request('search') }}"
                                    @else
                                        No hay clientes registrados aún.
                                    @endif
                                </p>
                                <a href="{{ route('clientes.create') }}" class="text-purple-600 font-bold hover:underline mt-2">Crear nuevo cliente</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-6 mb-12">
        {{ $clientes->withQueryString()->links() }} </div>
</div>
@endsection