@extends('layouts.app')

@section('titulo', 'Agendar Nueva Cita')

@section('content')

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- HEADER DINÁMICO --}}
    <div class="bg-custom-primary rounded-t-3xl p-8 shadow-xl text-white mb-[-2rem] relative z-0 overflow-hidden">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <h1 class="text-3xl font-black flex items-center gap-3" style="color: #ffffff; text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Agendar Nueva Cita
            </h1>
            <p class="mt-2 ml-14 font-medium italic" style="color: rgba(255,255,255,0.9); text-shadow: 0 1px 2px rgba(0,0,0,0.5);">Busca al cliente, selecciona sus pacientes y define el horario.</p>
        </div>
    </div>

    {{-- FORMULARIO PRINCIPAL --}}
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-8 relative z-10 mx-2 md:mx-0">
        
        <form id="formCita" action="{{ route('citas.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                
                {{-- COLUMNA IZQUIERDA: FLUJO DE TRABAJO --}}
                <div class="lg:col-span-2 space-y-10">
                    
                    {{-- PASO 1 --}}
                    <div class="border-l-4 border-custom-primary pl-6 py-2">
                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em] mb-6">
                            📍 PASO 1: IDENTIFICACIÓN
                        </h3>
                        
                        <div class="relative mb-4">
                            <label class="block text-gray-900 font-bold mb-2">Buscar Cliente <span class="text-red-600">*</span></label>
                            
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </span>
                                <input type="text" id="buscador_cliente" 
                                       class="w-full border-2 border-gray-200 rounded-2xl pl-12 pr-12 py-4 focus:outline-none focus:border-custom-primary focus:ring-4 focus:ring-custom-primary/10 transition-all bg-gray-50 text-gray-900 font-medium text-lg placeholder-gray-400" 
                                       placeholder="Nombre o teléfono..." autocomplete="off">
                                
                                <div id="loading_spinner" class="absolute inset-y-0 right-0 flex items-center pr-4 hidden">
                                    <svg class="animate-spin h-6 w-6 text-custom-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </div>
                            </div>

                            <ul id="lista_resultados" class="absolute z-50 w-full bg-white border border-gray-200 rounded-2xl shadow-2xl mt-2 max-h-64 overflow-y-auto hidden"></ul>

                            {{-- Tarjeta de cliente seleccionado --}}
                            <div id="cliente_seleccionado_card" class="hidden mt-4 bg-gray-50 p-5 rounded-2xl border-2 border-gray-200 animate-fade-in">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Cliente Seleccionado</p>
                                        <p class="text-xl font-black text-gray-900" id="nombre_cliente_seleccionado"></p>
                                        <p class="text-sm text-gray-600 font-bold" id="telefono_cliente_seleccionado"></p>
                                    </div>
                                    <button type="button" id="btn_cambiar_cliente" class="text-xs bg-white text-gray-700 border border-gray-300 px-4 py-2 rounded-xl font-black shadow-sm hover:bg-gray-100 transition">
                                        Cambiar
                                    </button>
                                </div>
                                <input type="hidden" id="cliente_id_seleccionado" name="cliente_id">
                            </div>
                        </div>
                    </div>

                    {{-- PASO 2 --}}
                    <div class="border-l-4 border-custom-primary pl-6 py-2">
                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em] mb-6">
                            🐾 PASO 2: SELECCIONA LOS PACIENTES
                        </h3>

                        <div id="contenedor_mascotas" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div id="lista_mascotas" class="contents"></div>
                            
                            <div id="alerta_limite" class="hidden col-span-full mt-2 p-4 bg-amber-50 border border-amber-200 rounded-2xl text-sm text-amber-800 font-bold flex items-center gap-2">
                                ⚠️ Has alcanzado el máximo de <span id="max_mascotas_texto">{{ $max_mascotas }}</span> mascotas permitidas por cita.
                            </div>
                        </div>

                        <div id="estado_vacio_mascotas" class="text-center py-10 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300">
                            <p class="text-gray-500 font-bold italic text-sm">Selecciona un cliente primero para ver sus mascotas</p>
                        </div>

                        <input type="hidden" id="mascotas_seleccionadas" name="mascotas" value="[]">
                    </div>

                    {{-- PASO 3 --}}
                    <div class="border-l-4 border-custom-primary pl-6 py-2">
                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em] mb-6">
                            PASO 3: DETALLES DE LA CITA
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-900 font-bold mb-2 ml-1">Fecha <span class="text-red-600">*</span></label>
                                <input type="date" name="fecha" id="fecha_cita" class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3 focus:border-custom-primary focus:ring-4 focus:ring-custom-primary/10 transition-all outline-none text-gray-900" required>
                            </div>
                            <div>
                                <label class="block text-gray-900 font-bold mb-2 ml-1">Hora <span class="text-red-600">*</span></label>
                                <input type="time" name="hora" id="hora_cita" class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3 focus:border-custom-primary focus:ring-4 focus:ring-custom-primary/10 transition-all outline-none text-gray-900" required>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-gray-900 font-bold mb-2 ml-1">Motivo de la Consulta <span class="text-red-600">*</span></label>
                            <input type="text" name="motivo" id="motivo_cita" class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3 focus:border-custom-primary focus:ring-4 focus:ring-custom-primary/10 transition-all outline-none text-gray-900 placeholder-gray-400" placeholder="Ej: Revisión general, Vacunación, Herida, etc." required>
                        </div>

                        {{-- AQUÍ ESTABA EL ERROR: Había borrado este campo, lo que hacía crashear el sistema --}}
                        <div class="mt-6">
                            <label class="block text-gray-900 font-bold mb-2 ml-1">Notas Adicionales <span class="text-gray-400 text-sm font-normal">(Opcional)</span></label>
                            <textarea name="notas" id="notas_cita" rows="3" class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3 focus:border-custom-primary focus:ring-4 focus:ring-custom-primary/10 transition-all outline-none text-gray-900 placeholder-gray-400" placeholder="Información extra que sea relevante..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- COLUMNA DERECHA: TICKET DE RESUMEN --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-28">
                        <div class="bg-gray-50 rounded-3xl border-2 border-gray-200 p-8 shadow-sm">
                            <h3 class="text-lg font-black text-gray-900 mb-6 uppercase tracking-tighter">Resumen de Cita</h3>

                            <div class="space-y-6">
                                <div class="pb-4 border-b border-gray-200">
                                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Cliente</span>
                                    <p id="resumen_cliente" class="text-sm font-black text-gray-900 mt-1 italic">Pendiente de seleccionar...</p>
                                </div>

                                <div class="pb-4 border-b border-gray-200">
                                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Pacientes</span>
                                    <div id="resumen_mascotas" class="mt-2 text-sm font-bold text-gray-900 italic">Ninguno seleccionado</div>
                                </div>

                                <div class="pb-4 border-b border-gray-200">
                                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Fecha y Hora</span>
                                    <p id="resumen_datetime" class="text-sm font-black text-gray-900 mt-1 italic">Por especificar</p>
                                </div>

                                {{-- AQUÍ ESTABA EL OTRO ERROR: Faltaba el bloque del Motivo --}}
                                <div class="pb-4 border-b border-gray-200">
                                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Motivo</span>
                                    <p id="resumen_motivo" class="text-sm font-black text-gray-900 mt-1 italic">Por especificar</p>
                                </div>

                                <div class="space-y-4 pt-4">
                                    <button type="submit" id="btn_confirmar_cita" 
                                            class="w-full bg-custom-primary text-white font-black py-4 rounded-2xl shadow-xl hover:brightness-110 transform hover:-translate-y-1 transition-all disabled:opacity-50 disabled:grayscale disabled:cursor-not-allowed border border-transparent" 
                                            disabled>
                                        Confirmar Cita
                                    </button>
                                    <a href="{{ route('citas.index') }}" class="block text-center text-xs font-black text-gray-500 hover:text-gray-900 uppercase tracking-widest transition">
                                        ← Volver / Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-4 bg-gray-100 rounded-2xl border border-gray-200 flex items-center gap-3">
                            <span class="text-2xl">💡</span>
                            <p class="text-[10px] font-bold text-gray-700 leading-tight">Estás permitiendo un máximo de {{ $max_mascotas }} mascotas por turno.</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const formCita = document.getElementById('formCita');
    const buscador = document.getElementById('buscador_cliente');
    const listaResultados = document.getElementById('lista_resultados');
    const clienteCard = document.getElementById('cliente_seleccionado_card');
    const clienteInput = document.getElementById('cliente_id_seleccionado');
    const btnCambiarCliente = document.getElementById('btn_cambiar_cliente');
    const loadingSpinner = document.getElementById('loading_spinner');
    const btnConfirmar = document.getElementById('btn_confirmar_cita');
    
    let clienteActualId = null;
    let mascotasSeleccionadas = [];
    let debounceTimer = null;

    let maxMascotas = {{ $max_mascotas ?? 3 }}; 

    buscador.addEventListener('input', function(e) {
        clearTimeout(debounceTimer);
        const query = e.target.value.trim();

        if (query.length < 2) {
            listaResultados.classList.add('hidden');
            loadingSpinner.classList.add('hidden');
            return;
        }

        loadingSpinner.classList.remove('hidden');
        
        debounceTimer = setTimeout(() => {
            fetch(`/api/buscar-clientes?q=${encodeURIComponent(query)}`)
                .then(r => r.json())
                .then(clientes => {
                    loadingSpinner.classList.add('hidden');
                    
                    if (clientes.length === 0) {
                        listaResultados.innerHTML = '<li class="px-4 py-3 text-gray-500 text-center font-medium">No se encontraron clientes</li>';
                        listaResultados.classList.remove('hidden');
                        return;
                    }

                    listaResultados.innerHTML = clientes.map(cliente => `
                        <li class="border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors">
                            <button type="button" class="w-full text-left px-4 py-3 cliente-resultado" data-id="${cliente.id}" data-nombre="${cliente.nombre}" data-telefono="${cliente.telefono}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-gray-900">${cliente.nombre}</p>
                                        <p class="text-sm text-gray-600 font-medium">📞 ${cliente.telefono}</p>
                                    </div>
                                    <span class="inline-block px-2 py-1 bg-gray-200 text-gray-800 rounded-lg text-xs font-bold">
                                        ${cliente.mascotas_count} mascota${cliente.mascotas_count !== 1 ? 's' : ''}
                                    </span>
                                </div>
                            </button>
                        </li>
                    `).join('');

                    listaResultados.classList.remove('hidden');

                    document.querySelectorAll('.cliente-resultado').forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            seleccionarCliente(this.dataset.id, this.dataset.nombre, this.dataset.telefono);
                        });
                    });
                })
                .catch(err => console.error('[ERROR] Búsqueda:', err));
        }, 300);
    });

    function seleccionarCliente(id, nombre, telefono) {
        clienteActualId = id;
        clienteInput.value = id;
        buscador.value = '';
        listaResultados.classList.add('hidden');
        document.getElementById('nombre_cliente_seleccionado').textContent = nombre;
        document.getElementById('telefono_cliente_seleccionado').textContent = telefono;
        clienteCard.classList.remove('hidden');
        document.getElementById('resumen_cliente').innerHTML = `<span class="text-gray-900 font-black">${nombre}</span>`;
        mascotasSeleccionadas = [];
        document.getElementById('lista_mascotas').innerHTML = '';
        cargarMascotas(id);
    }

    btnCambiarCliente.addEventListener('click', function(e) {
        e.preventDefault();
        clienteActualId = null;
        clienteInput.value = '';
        clienteCard.classList.add('hidden');
        buscador.value = '';
        buscador.focus();
        mascotasSeleccionadas = [];
        document.getElementById('contenedor_mascotas').classList.add('hidden');
        document.getElementById('estado_vacio_mascotas').classList.remove('hidden');
        document.getElementById('resumen_cliente').innerHTML = '<span class="text-gray-500 italic">Pendiente de seleccionar...</span>';
        document.getElementById('resumen_mascotas').innerHTML = '<p class="text-sm text-gray-500 italic">Ninguno seleccionado</p>';
        validarFormulario();
    });

    function cargarMascotas(clienteId) {
        fetch(`/api/cliente/${clienteId}/mascotas`)
            .then(r => r.json())
            .then(mascotas => {
                const contenedor = document.getElementById('contenedor_mascotas');
                const listaMascotas = document.getElementById('lista_mascotas');

                if (mascotas.length === 0) {
                    document.getElementById('estado_vacio_mascotas').innerHTML = '<p class="text-gray-500 font-bold">Este cliente no tiene mascotas registradas.</p>';
                    contenedor.classList.add('hidden');
                    return;
                }

                contenedor.classList.remove('hidden');
                document.getElementById('estado_vacio_mascotas').classList.add('hidden');

                listaMascotas.innerHTML = mascotas.map(mascota => `
                    <label class="flex items-center p-4 bg-white border-2 border-gray-200 rounded-2xl hover:border-custom-primary hover:bg-gray-50 cursor-pointer transition-all shadow-sm">
                        <input type="checkbox" value="${mascota.id}" class="w-5 h-5 text-custom-primary rounded cursor-pointer mascota-input border-gray-300 focus:ring-custom-primary" onchange="window.actualizarMascotas()">
                        <div class="ml-3">
                            <p class="font-black text-gray-900 text-lg leading-tight">${mascota.nombre}</p>
                            <p class="text-xs text-gray-500 font-bold uppercase">${mascota.especie} • ${mascota.raza}</p>
                        </div>
                    </label>
                `).join('');
            });
    }

    window.actualizarMascotas = function() {
        const checkboxes = document.querySelectorAll('.mascota-input:checked');
        const allCheckboxes = document.querySelectorAll('.mascota-input');
        
        mascotasSeleccionadas = Array.from(checkboxes).map(cb => parseInt(cb.value));
        
        const alertaLimite = document.getElementById('alerta_limite');
        
        allCheckboxes.forEach(checkbox => {
            if (mascotasSeleccionadas.length >= maxMascotas && !checkbox.checked) {
                checkbox.disabled = true;
                checkbox.parentElement.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-100');
            } else {
                checkbox.disabled = false;
                checkbox.parentElement.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-100');
            }
        });

        if (mascotasSeleccionadas.length >= maxMascotas) {
            if(alertaLimite) alertaLimite.classList.remove('hidden');
        } else {
            if(alertaLimite) alertaLimite.classList.add('hidden');
        }

        document.getElementById('mascotas_seleccionadas').value = JSON.stringify(mascotasSeleccionadas);

        const resumenMascotas = document.getElementById('resumen_mascotas');
        if (mascotasSeleccionadas.length === 0) {
            resumenMascotas.innerHTML = '<p class="text-sm text-gray-500 italic">Ninguno seleccionado</p>';
        } else {
            const nombres = Array.from(checkboxes).map(cb => cb.parentElement.querySelector('p').textContent);
            resumenMascotas.innerHTML = `<ul class="space-y-1">${nombres.map(n => `<li class="text-sm font-bold text-gray-900">🐾 ${n}</li>`).join('')}</ul>`;
        }

        validarFormulario();
    };

    document.getElementById('fecha_cita').addEventListener('change', () => { actualizarResumenDateTime(); validarFormulario(); });
    document.getElementById('hora_cita').addEventListener('change', () => { actualizarResumenDateTime(); validarFormulario(); });
    
    document.getElementById('motivo_cita').addEventListener('input', function() {
        // Al escribir aquí, ahora SÍ encuentra la vista previa y ya no da error
        document.getElementById('resumen_motivo').innerHTML = this.value ? `<span class="text-gray-900 font-bold">${this.value}</span>` : '<span class="text-gray-500 italic">Por especificar</span>';
        validarFormulario();
    });

    function actualizarResumenDateTime() {
        const fecha = document.getElementById('fecha_cita').value;
        const hora = document.getElementById('hora_cita').value;
        if (fecha && hora) {
            const fechaObj = new Date(fecha + 'T00:00:00');
            const fechaFormato = fechaObj.toLocaleDateString('es-MX', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            document.getElementById('resumen_datetime').innerHTML = `<span class="text-gray-900 font-black">${fechaFormato}</span><br><span class="text-gray-600 font-bold">a las ${hora}hs</span>`;
        } else {
            document.getElementById('resumen_datetime').innerHTML = '<span class="text-gray-500 italic">Por especificar</span>';
        }
    }

    function validarFormulario() {
        const todosValidos = clienteActualId && mascotasSeleccionadas.length > 0 && 
                             document.getElementById('fecha_cita').value && 
                             document.getElementById('hora_cita').value && 
                             document.getElementById('motivo_cita').value.trim();
        
        btnConfirmar.disabled = !todosValidos;
    }

    formCita.addEventListener('submit', async function(e) {
        e.preventDefault();
        const datos = {
            cliente_id: parseInt(clienteActualId),
            mascotas: mascotasSeleccionadas,
            fecha: document.getElementById('fecha_cita').value,
            hora: document.getElementById('hora_cita').value,
            motivo: document.getElementById('motivo_cita').value,
            // Al estar de vuelta el campo notas, esto ya no arroja "null error"
            notas: document.getElementById('notas_cita').value || null,
        };

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(datos)
            });
            const data = await response.json();
            if (response.ok && data.success) {
                alert('✅ ¡Cita creada exitosamente!');
                window.location.href = `/citas`;
            } else {
                alert('❌ Error: ' + (data.message || 'Error desconocido'));
            }
        } catch (error) {
            alert('❌ Error de conexión');
        }
    });
});
</script>

@endsection