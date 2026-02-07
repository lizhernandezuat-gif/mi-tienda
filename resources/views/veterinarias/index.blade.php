@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-gradient-to-r from-green-50 to-teal-50 p-6 rounded-xl shadow-xl">
        <h1 class="text-3xl font-extrabold mb-4">Veterinarias</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
        @endif

        <div class="mb-6">
            <a href="{{ route('veterinarias.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-full">Crear nueva sucursal</a>
        </div>

        @if($veterinarias->isEmpty())
            <div class="p-6 bg-white rounded-lg shadow">No hay veterinarias registradas.</div>
        @else
            <div class="grid grid-cols-1 gap-4">
                @foreach($veterinarias as $v)
                    <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
                        <div>
                            <div class="text-lg font-semibold">{{ $v->nombre }} @if(!$v->activo) <span class="text-sm text-gray-500">(inactiva)</span> @endif</div>
                            <div class="text-sm text-gray-600">{{ $v->direccion }}</div>
                            <div class="text-sm text-gray-600">{{ $v->telefono }}</div>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('veterinarias.edit', $v) }}" class="text-sm px-3 py-2 bg-yellow-400 rounded-full">Editar</a>
                            <a href="{{ route('clientes.create', ['veterinaria_id' => $v->id]) }}" class="text-sm px-3 py-2 bg-indigo-500 text-white rounded-full">Crear cliente en esta sucursal</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $veterinarias->links() }}</div>
        @endif
    </div>
</div>
@endsection