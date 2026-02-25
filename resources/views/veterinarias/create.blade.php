@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    {{-- Cambiamos el gradiente fijo por bg-custom-light que ya definiste --}}
    <div class="bg-custom-light p-6 rounded-xl shadow-xl border border-gray-100">
        <h1 class="text-3xl font-extrabold mb-4 text-gray-800">Crear veterinaria (sucursal)</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg border-l-4 border-red-500">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('veterinarias.store') }}" method="POST">
            @csrf
            <div class="bg-white rounded-2xl shadow-2xl p-6 border-4 border-white">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Nombre de la sucursal</label>
                        {{-- Aplicamos border-custom-primary en el focus para coherencia --}}
                        <input type="text" name="nombre" value="{{ old('nombre') }}" 
                               class="w-full border border-gray-200 p-3 rounded-full shadow-sm focus:ring-2 focus:ring-opacity-50 focus:border-custom-primary" required>
                        @error('nombre')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion') }}" 
                               class="w-full border border-gray-200 p-3 rounded-full shadow-sm focus:border-custom-primary">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" 
                               class="w-full border border-gray-200 p-3 rounded-full shadow-sm focus:border-custom-primary" 
                               pattern="^\+?[0-9]{7,15}$" title="Incluye el prefijo de país, sólo números y un '+' opcional">
                        @error('telefono')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                        <div class="text-gray-400 text-xs mt-1">Opcional. Ej: +34123456789</div>
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="inline-flex items-center gap-3 cursor-pointer">
                            {{-- Cambiamos text-indigo-600 por text-custom-primary --}}
                            <input type="checkbox" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }} 
                                   class="h-5 w-5 text-custom-primary rounded border-gray-300 focus:ring-custom-primary">
                            <span class="font-semibold text-gray-700">Activo</span>
                        </label>
                    </div>

                    <div class="mt-4">
                        <label class="inline-flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" id="create-client-toggle" 
                                   class="h-5 w-5 text-custom-primary rounded border-gray-300 focus:ring-custom-primary">
                            <span class="font-semibold text-gray-700">Crear también un cliente para esta sucursal</span>
                        </label>
                    </div>

                    <div id="create-client-panel" class="mt-4 hidden bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Nombre cliente</label>
                                <input type="text" name="cliente_nombre" id="cliente_nombre" value="{{ old('cliente_nombre') }}" 
                                       class="w-full border border-gray-200 p-3 rounded-full shadow-sm focus:border-custom-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Teléfono cliente</label>
                                <input type="text" name="cliente_telefono" id="cliente_telefono" value="{{ old('cliente_telefono') }}" 
                                       class="w-full border border-gray-200 p-3 rounded-full shadow-sm focus:border-custom-primary" placeholder="+54...">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Nombre mascota</label>
                                <input type="text" name="cliente_nombre_mascota" id="cliente_nombre_mascota" value="{{ old('cliente_nombre_mascota') }}" 
                                       class="w-full border border-gray-200 p-3 rounded-full shadow-sm focus:border-custom-primary">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-4">
                        {{-- BOTÓN DINÁMICO: bg-custom-primary y brillo para el hover --}}
                        <button type="submit" 
                                class="px-8 py-3 bg-custom-primary text-white rounded-full font-bold shadow-lg transform transition hover:scale-105 hover:brightness-110 active:scale-95">
                            Crear Sucursal
                        </button>
                        
                        <a href="{{ route('veterinarias.index') }}" 
                           class="px-6 py-3 text-gray-500 hover:text-gray-700 font-semibold transition">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('create-client-toggle').addEventListener('change', function(e){
        var panel = document.getElementById('create-client-panel');
        if (e.target.checked) {
            panel.classList.remove('hidden');
            panel.classList.add('animate-fade-in-down'); // Opcional: una pequeña animación
        } else {
            panel.classList.add('hidden');
        }
    });
</script>
@endsection