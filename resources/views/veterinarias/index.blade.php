@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    {{-- 🎨 Fondo dinámico suave --}}
    <div class="bg-custom-light p-6 rounded-xl shadow-xl border border-custom-primary/10">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-extrabold text-custom-primary">Veterinarias</h1>
            
            {{-- Botón principal dinámico con efecto de brillo --}}
            <a href="{{ route('veterinarias.create') }}" 
               class="px-6 py-2 bg-custom-primary text-white rounded-full shadow-md hover:brightness-110 transition-all transform hover:scale-105 active:scale-95 font-semibold">
                + Nueva sucursal
            </a>
        </div>

        @if(session('success'))
            {{-- Alerta: Usamos un fondo ligeramente más sólido para asegurar legibilidad --}}
            <div class="mb-4 p-4 bg-white/50 backdrop-blur-sm text-custom-primary border-l-4 border-custom-primary rounded-r-lg shadow-sm font-medium">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </span>
            </div>
        @endif

        @if($veterinarias->isEmpty())
            <div class="p-10 bg-white rounded-xl shadow-sm text-center border border-gray-100">
                <div class="text-gray-400 mb-2">
                    <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <p class="text-gray-500 font-medium">No hay veterinarias registradas aún.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4">
                @foreach($veterinarias as $v)
                    <div class="bg-white p-5 rounded-xl shadow-sm flex flex-col md:flex-row justify-between items-center border-l-8 border-custom-primary hover:shadow-md transition-shadow">
                        <div class="mb-4 md:mb-0">
                            <div class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                {{ $v->nombre }} 
                                @if(!$v->activo) 
                                    <span class="px-2 py-0.5 text-xs bg-gray-100 text-gray-400 rounded-full font-normal italic">Inactiva</span> 
                                @endif
                            </div>
                            <div class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                                <span>📍</span> {{ $v->direccion }}
                            </div>
                            <div class="text-sm text-gray-500 flex items-center gap-1">
                                <span>📞</span> {{ $v->telefono }}
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            {{-- Botón Editar: Usamos una versión sutil para no competir con el botón de Crear Cliente --}}
                            <a href="{{ route('veterinarias.edit', $v) }}" 
                               class="text-sm px-4 py-2 border-2 border-gray-100 text-gray-600 rounded-full hover:bg-gray-50 hover:text-custom-primary hover:border-custom-primary/30 transition-all font-semibold">
                                Editar
                            </a>

                            {{-- Botón Crear Cliente: Dinámico total --}}
                            <a href="{{ route('clientes.create', ['veterinaria_id' => $v->id]) }}" 
                               class="text-sm px-4 py-2 bg-custom-primary text-white rounded-full shadow-sm hover:brightness-110 transition-all font-semibold flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Cliente
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $veterinarias->links() }}
            </div>
        @endif
    </div>
</div>
@endsection