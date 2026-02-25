@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        
        {{-- Header con Identidad Visual --}}
        <div class="bg-custom-primary px-8 py-10 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h1 class="text-3xl font-black tracking-tight">Carnet de Vacunación</h1>
                    <p class="text-white/80 italic mt-1 font-medium">Historial médico preventivo</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <button class="bg-white/20 backdrop-blur-md border border-white/30 px-6 py-2 rounded-xl font-bold hover:bg-white/30 transition shadow-lg">
                        + Registrar Vacuna
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8">
            {{-- Filtros Rápidos con bg-custom-light --}}
            <div class="flex gap-2 mb-8 overflow-x-auto pb-2">
                <span class="px-4 py-2 bg-custom-primary text-white rounded-full text-sm font-bold shadow-md cursor-pointer">Todas</span>
                <span class="px-4 py-2 bg-custom-light text-custom-primary rounded-full text-sm font-bold hover:brightness-95 cursor-pointer">Pendientes</span>
                <span class="px-4 py-2 bg-gray-100 text-gray-500 rounded-full text-sm font-bold hover:bg-gray-200 cursor-pointer">Completadas</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                            <th class="px-4 py-4 text-custom-primary">Vacuna</th>
                            <th class="px-4 py-4">Mascota</th>
                            <th class="px-4 py-4">Fecha</th>
                            <th class="px-4 py-4">Estado</th>
                            <th class="px-4 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        {{-- Ejemplo de fila dinámica --}}
                        <tr class="group hover:bg-gray-50/50 transition">
                            <td class="px-4 py-5">
                                <div class="font-bold text-gray-800">Parvovirus</div>
                                <div class="text-xs text-gray-400 font-medium italic">Refuerzo Anual</div>
                            </td>
                            <td class="px-4 py-5">
                                <span class="font-semibold text-gray-700">Firulais</span>
                            </td>
                            <td class="px-4 py-5 text-sm text-gray-600 font-medium">24 Feb, 2026</td>
                            <td class="px-4 py-5">
                                <span class="px-3 py-1 bg-custom-light text-custom-primary text-xs font-black rounded-lg border border-custom-primary/10">
                                    APLICADA
                                </span>
                            </td>
                            <td class="px-4 py-5 text-right">
                                <button class="text-gray-400 hover:text-custom-primary transition">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 flex justify-between items-center text-xs font-bold text-gray-400 uppercase tracking-widest">
            <span>Total: 12 Vacunas registradas</span>
            <a href="#" class="text-custom-primary hover:underline">Descargar Carnet (PDF)</a>
        </div>
    </div>
</div>
@endsection