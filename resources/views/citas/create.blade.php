@extends('layouts.app')

@section('titulo', 'Agendar Nueva Cita')

@section('content')

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- HEADER CON GRADIENTE -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-500 rounded-t-2xl p-8 shadow-lg text-white mb-[-2rem] relative z-0">
        <h1 class="text-3xl font-bold flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Agendar Nueva Cita
        </h1>
        <p class="text-purple-100 mt-2 ml-12">Busca al cliente, selecciona sus pacientes y define el horario.</p>
    </div>

    <!-- FORMULARIO PRINCIPAL -->
    <div class="bg-white rounded-b-2xl shadow-2xl border border-gray-100 p-8 relative z-10 mx-2 md:mx-0">
        
        <form id="formCita" action="{{ route('citas.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- COLUMNA IZQUIERDA: CAMPOS DE ENTRADA -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- ========== PASO 1: IDENTIFICACIÓN ========== -->
                    <div class="border-l-4 border-purple-500 pl-6 py-2">
                        <h3 class="text-sm font-bold text-purple-600 uppercase tracking-wider mb-4">
                            📍 PASO 1: IDENTIFICACIÓN
                        </h3>
                        
                        <!-- BUSCADOR DE CLIENTE -->
                        <div class="relative mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                Buscar Cliente
                                <span class="text-red-500">*</span>
                            </label>
                            
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </span>
                                <input 
                                    type="text" 
                                    id="buscador_cliente" 
                                    class="w-full border border-gray-300 rounded-lg pl-10 pr-10 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors bg-gray-50"
                                    placeholder="Ej: Maria o 8333..."
                                    autocomplete="off">
                                
                                <!-- Loading spinner -->
                                <div id="loading_spinner" class="absolute inset-y-0 right-0 flex items-center pr-3 hidden">
                                    <svg class="animate-spin h-5 w-5 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- LISTA DE RESULTADOS (DROPDOWN) -->
                            <ul id="lista_resultados" class="absolute z-50 w-full bg-white border border-gray-200 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto hidden"></ul>

                            <!-- CLIENTE SELECCIONADO -->
                            <div id="cliente_seleccionado_card" class="hidden mt-4 bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-200 rounded-lg p-4 animate-fade-in">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-600">Cliente Seleccionado</p>
                                        <p class="text-lg font-bold text-gray-900" id="nombre_cliente_seleccionado"></p>
                                        <p class="text-sm text-gray-600 mt-1">📞 <span id="telefono_cliente_seleccionado"></span></p>
                                    </div>
                                    <button type="button" id="btn_cambiar_cliente" class="text-sm text-purple-600 hover:text-purple-800 font-semibold">
                                         Cambiar
                                    </button>
                                </div>
                                <input type="hidden" id="cliente_id_seleccionado" name="cliente_id">
                            </div>
                        </div>
                    </div>

                    <!-- ========== PASO 2: SELECCIÓN DE MASCOTAS ========== -->
                    <div class="border-l-4 border-blue-500 pl-6 py-2">
                        <h3 class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-4">
                            🐾 PASO 2: SELECCIONA LOS PACIENTES
                        </h3>

                        <div id="contenedor_mascotas" class="hidden space-y-3">
                            <div id="lista_mascotas"></div>
                            
                            <!-- ADVERTENCIA DE LÍMITE -->
                            <div id="alerta_limite" class="hidden mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-700">
                                ⚠️ Has alcanzado el máximo de <span id="max_mascotas_texto">3</span> mascotas permitidas por cita.
                            </div>
                        </div>

                        <!-- ESTADO VACÍO -->
                        <div id="estado_vacio_mascotas" class="text-center py-8 text-gray-500">
                            <svg class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h-4.5m4.5 0h4.5m-4.5 0h4.5M7 10h4.5m-4.5 0H3m4.5 0H7m0 0H3m4.5 0H7" />
                            </svg>
                            <p class="text-gray-500">Selecciona un cliente primero para ver sus mascotas</p>
                        </div>

                        <input type="hidden" id="mascotas_seleccionadas" name="mascotas" value="[]">
                    </div>

                    <!-- ========== PASO 3: DETALLES DE LA CITA ========== -->
                    <div class="border-l-4 border-green-500 pl-6 py-2">
                        <h3 class="text-sm font-bold text-green-600 uppercase tracking-wider mb-4">
                             PASO 3: DETALLES DE LA CITA
                        </h3>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- FECHA -->
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    Fecha <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    name="fecha" 
                                    id="fecha_cita"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    required>
                                <p class="text-xs text-gray-500 mt-1">A partir de mañana</p>
                            </div>

                            <!-- HORA -->
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    Hora <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="time" 
                                    name="hora" 
                                    id="hora_cita"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    required>
                            </div>
                        </div>

                        <!-- MOTIVO -->
                        <div class="mt-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                Motivo de la Consulta <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="motivo" 
                                id="motivo_cita"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Ej: Revisión general, Vacunación, Herida, etc."
                                required>
                        </div>

                        <!-- NOTAS -->
                        <div class="mt-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                Notas Adicionales
                                <span class="text-gray-400 text-sm">(Opcional)</span>
                            </label>
                            <textarea 
                                name="notas" 
                                id="notas_cita"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Información extra que sea relevante..."
                                rows="3"></textarea>
                        </div>
                    </div>

                </div>

                <!-- COLUMNA DERECHA: RESUMEN Y ACCIONES -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6">
                        
                        <!-- TARJETA DE RESUMEN -->
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl border-2 border-purple-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-6"> Resumen de Cita</h3>

                            <!-- CLIENTE -->
                            <div class="mb-4 pb-4 border-b border-purple-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase">Cliente</p>
                                <p id="resumen_cliente" class="text-sm font-semibold text-gray-900 mt-1">
                                    <span class="text-gray-400">Pendiente de seleccionar...</span>
                                </p>
                            </div>

                            <!-- MASCOTAS -->
                            <div class="mb-4 pb-4 border-b border-purple-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase">Pacientes</p>
                                <div id="resumen_mascotas" class="mt-2">
                                    <p class="text-sm text-gray-400">Ninguno seleccionado</p>
                                </div>
                            </div>

                            <!-- FECHA Y HORA -->
                            <div class="mb-4 pb-4 border-b border-purple-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase">Fecha y Hora</p>
                                <p id="resumen_datetime" class="text-sm font-semibold text-gray-900 mt-1">
                                    <span class="text-gray-400">Por especificar</span>
                                </p>
                            </div>

                            <!-- MOTIVO -->
                            <div class="mb-6">
                                <p class="text-xs font-semibold text-gray-500 uppercase">Motivo</p>
                                <p id="resumen_motivo" class="text-sm font-semibold text-gray-900 mt-1">
                                    <span class="text-gray-400">Por especificar</span>
                                </p>
                            </div>

                            <!-- BOTONES DE ACCIÓN -->
                            <div class="space-y-3">
                                <button 
                                    type="submit" 
                                    id="btn_confirmar_cita"
                                    class="w-full bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600 text-white font-bold py-3 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                     Confirmar Cita
                                </button>

                                <a href="{{ route('citas.index') }}" class="block text-center text-gray-600 hover:text-gray-800 font-semibold py-2 transition-colors">
                                    ← Volver
                                </a>
                            </div>
                        </div>

                        <!-- INFORMACIÓN DE LÍMITE -->
                        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-xs font-semibold text-blue-600 uppercase">Máximo de Pacientes</p>
                            <p class="text-sm text-blue-900 mt-2">
                                Máximo <span id="max_mascotas_limit" class="font-bold">3</span> mascotas por cita
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </form>
    </div>

</div>

<!-- ========== JAVASCRIPT AJAX OPTIMIZADO CON DEBUGGING ========== -->
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
    let maxMascotas = 3;

    // ========== 1. OBTENER CONFIGURACIÓN ==========
    console.log('[INIT] Obteniendo configuración...');
    fetch('/api/veterinaria/config')
        .then(r => r.json())
        .then(data => {
            console.log('[CONFIG] Recibido:', data);
            maxMascotas = data.max_mascotas;
            document.getElementById('max_mascotas_texto').textContent = maxMascotas;
            document.getElementById('max_mascotas_limit').textContent = maxMascotas;
        })
        .catch(err => console.error('[ERROR] Config:', err));

    // ========== 2. BÚSQUEDA CON DEBOUNCE ==========
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
                        listaResultados.innerHTML = '<li class="px-4 py-3 text-gray-500 text-center">No se encontraron clientes</li>';
                        listaResultados.classList.remove('hidden');
                        return;
                    }

                    listaResultados.innerHTML = clientes.map(cliente => `
                        <li class="border-b border-gray-100 hover:bg-purple-50 cursor-pointer transition-colors">
                            <button type="button" class="w-full text-left px-4 py-3 cliente-resultado" data-id="${cliente.id}" data-nombre="${cliente.nombre}" data-telefono="${cliente.telefono}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold text-gray-900">${cliente.nombre}</p>
                                        <p class="text-sm text-gray-600">📞 ${cliente.telefono}</p>
                                    </div>
                                    <span class="inline-block px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-semibold">
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

    // ========== 3. SELECCIONAR CLIENTE ==========
    function seleccionarCliente(id, nombre, telefono) {
        clienteActualId = id;
        clienteInput.value = id;
        
        buscador.value = '';
        listaResultados.classList.add('hidden');
        
        document.getElementById('nombre_cliente_seleccionado').textContent = nombre;
        document.getElementById('telefono_cliente_seleccionado').textContent = telefono;
        clienteCard.classList.remove('hidden');

        document.getElementById('resumen_cliente').innerHTML = `<span class="text-purple-600 font-bold">${nombre}</span>`;

        mascotasSeleccionadas = [];
        document.getElementById('lista_mascotas').innerHTML = '';

        cargarMascotas(id);

        document.querySelector('.border-l-4.border-blue-500').scrollIntoView({ behavior: 'smooth' });
    }

    // ========== 4. CAMBIAR CLIENTE ==========
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
        document.getElementById('resumen_cliente').innerHTML = '<span class="text-gray-400">Pendiente de seleccionar...</span>';
        document.getElementById('resumen_mascotas').innerHTML = '<p class="text-sm text-gray-400">Ninguno seleccionado</p>';
    });

    // ========== 5. CARGAR MASCOTAS ==========
    function cargarMascotas(clienteId) {
        fetch(`/api/cliente/${clienteId}/mascotas`)
            .then(r => r.json())
            .then(mascotas => {
                const contenedor = document.getElementById('contenedor_mascotas');
                const listaMascotas = document.getElementById('lista_mascotas');

                if (mascotas.length === 0) {
                    document.getElementById('estado_vacio_mascotas').innerHTML = '<p class="text-gray-500">Este cliente no tiene mascotas registradas.</p>';
                    contenedor.classList.add('hidden');
                    return;
                }

                contenedor.classList.remove('hidden');
                document.getElementById('estado_vacio_mascotas').classList.add('hidden');

                listaMascotas.innerHTML = mascotas.map(mascota => `
                    <label class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 cursor-pointer transition-all mascota-checkbox">
                        <input type="checkbox" value="${mascota.id}" class="w-5 h-5 text-purple-600 rounded cursor-pointer mascota-input" onchange="window.actualizarMascotas()">
                        <div class="ml-3">
                            <p class="font-semibold text-gray-900">${mascota.nombre}</p>
                            <p class="text-sm text-gray-600">${mascota.especie} • ${mascota.raza}</p>
                        </div>
                    </label>
                `).join('');
            })
            .catch(err => console.error('[ERROR] Mascotas:', err));
    }

    // ========== 6. ACTUALIZAR MASCOTAS (REPARADO) ==========
    window.actualizarMascotas = function() {
        const checkboxes = document.querySelectorAll('.mascota-input:checked');
        const allCheckboxes = document.querySelectorAll('.mascota-input');
        
        mascotasSeleccionadas = Array.from(checkboxes).map(cb => parseInt(cb.value));
        console.log('[MASCOTAS] Seleccionadas:', mascotasSeleccionadas.length, 'máximo:', maxMascotas);
        
        const alertaLimite = document.getElementById('alerta_limite');
        
        // ✅ ESTO ERA EL ERROR: Ahora deshabilita/habilita correctamente
        allCheckboxes.forEach(checkbox => {
            if (mascotasSeleccionadas.length >= maxMascotas && !checkbox.checked) {
                checkbox.disabled = true;
                checkbox.parentElement.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                checkbox.disabled = false;
                checkbox.parentElement.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });

        // Mostrar/ocultar alerta
        if (mascotasSeleccionadas.length >= maxMascotas) {
            alertaLimite.classList.remove('hidden');
        } else {
            alertaLimite.classList.add('hidden');
        }

        // Actualizar input hidden
        document.getElementById('mascotas_seleccionadas').value = JSON.stringify(mascotasSeleccionadas);

        // Actualizar resumen
        const resumenMascotas = document.getElementById('resumen_mascotas');
        if (mascotasSeleccionadas.length === 0) {
            resumenMascotas.innerHTML = '<p class="text-sm text-gray-400">Ninguno seleccionado</p>';
        } else {
            const nombres = Array.from(checkboxes).map(cb => cb.parentElement.querySelector('p').textContent);
            resumenMascotas.innerHTML = `<ul class="space-y-1">${nombres.map(n => `<li class="text-sm">🐾 ${n}</li>`).join('')}</ul>`;
        }

        validarFormulario();
    };

    // ========== 7. ACTUALIZAR RESUMEN ==========
    document.getElementById('fecha_cita').addEventListener('change', function() {
        actualizarResumenDateTime();
        validarFormulario();
    });

    document.getElementById('hora_cita').addEventListener('change', function() {
        actualizarResumenDateTime();
        validarFormulario();
    });

    document.getElementById('motivo_cita').addEventListener('input', function() {
        document.getElementById('resumen_motivo').innerHTML = this.value || '<span class="text-gray-400">Por especificar</span>';
        validarFormulario();
    });

    function actualizarResumenDateTime() {
        const fecha = document.getElementById('fecha_cita').value;
        const hora = document.getElementById('hora_cita').value;

        if (fecha && hora) {
            const fechaObj = new Date(fecha + 'T00:00:00');
            const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const fechaFormato = fechaObj.toLocaleDateString('es-MX', opciones);
            document.getElementById('resumen_datetime').innerHTML = `<span class="text-purple-600 font-semibold">${fechaFormato}</span><br><span class="text-gray-600">a las ${hora}hs</span>`;
        } else {
            document.getElementById('resumen_datetime').innerHTML = '<span class="text-gray-400">Por especificar</span>';
        }
    }

    // ========== 8. VALIDAR FORMULARIO ==========
    function validarFormulario() {
        const clienteValido = clienteActualId !== null;
        const mascotasValidas = mascotasSeleccionadas.length > 0;
        const fechaValida = document.getElementById('fecha_cita').value !== '';
        const horaValida = document.getElementById('hora_cita').value !== '';
        const motivoValido = document.getElementById('motivo_cita').value.trim() !== '';

        const todosValidos = clienteValido && mascotasValidas && fechaValida && horaValida && motivoValido;
        btnConfirmar.disabled = !todosValidos;
    }

    // ========== 9. ENVIAR FORMULARIO (REPARADO) ==========
    formCita.addEventListener('submit', async function(e) {
        e.preventDefault();

        const datos = {
            cliente_id: parseInt(clienteActualId),
            mascotas: mascotasSeleccionadas.map(m => parseInt(m)),
            fecha: document.getElementById('fecha_cita').value,
            hora: document.getElementById('hora_cita').value,
            motivo: document.getElementById('motivo_cita').value,
            notas: document.getElementById('notas_cita').value || null,
        };

        console.log('[SUBMIT] Enviando:', datos);

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
            console.log('[RESPONSE]', response.status, data);

            if (response.ok && data.success) {
                alert('✅ ¡Cita creada exitosamente!');
                window.location.href = `/citas`;
            } else {
                alert('❌ Error: ' + (data.message || 'Error desconocido'));
            }
        } catch (error) {
            console.error('[ERROR]', error);
            alert('❌ Error: ' + error.message);
        }
    });
});
</script>

@endsection
