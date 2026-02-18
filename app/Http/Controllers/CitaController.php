<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Mascota;
use App\Models\Veterinaria;
use App\Services\WhatsAppMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     * Dashboard de citas con semáforo (pendientes, confirmadas, completadas)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Obtener citas del veterinario logueado
        $citas = Cita::with(['cliente', 'mascotas'])
            ->whereHas('cliente', function ($q) use ($user) {
                $q->where('veterinaria_id', $user->veterinaria_id);
            })
            ->orderBy('fecha_hora_inicio', 'desc')
            ->paginate(15);

        // Estadísticas para el semáforo
        $estadisticas = [
            'total' => $citas->count(),
            'pendientes' => $citas->where('estado', 'pendiente')->count(),
            'confirmadas' => $citas->where('estado', 'confirmada')->count(),
            'completadas' => $citas->where('estado', 'completada')->count(),
        ];

        return view('citas.index', compact('citas', 'estadisticas'));
    }

    /**
     * Show the form for creating a new resource.
     * Formulario de creación de cita con búsqueda avanzada
     */
    public function create()
    {
        $user = Auth::user();
        $max_mascotas = $user->getConfig('max_mascotas', 3);

        return view('citas.create', compact('max_mascotas'));
    }

    /**
     * Store a newly created resource in storage.
     * Guarda la cita, mascotas asociadas y genera mensaje WhatsApp
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $max_mascotas = $user->getConfig('max_mascotas', 3);

        // ========== VALIDACIÓN ==========
        $validated = $request->validate([
            'cliente_id' => 'required|integer|exists:clientes,id',
            'mascotas' => 'required|array|min:1|max:' . $max_mascotas,
            'mascotas.*' => 'integer|exists:mascotas,id',
            'fecha' => 'required|date_format:Y-m-d|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'motivo' => 'required|string|max:255',
            'notas' => 'nullable|string|max:1000',
        ]);

        // Verificar que todas las mascotas pertenecen al cliente seleccionado
        $cliente = Cliente::findOrFail($validated['cliente_id']);
        $mascotasDelCliente = Mascota::where('cliente_id', $cliente->id)->pluck('id')->toArray();
        
        foreach ($validated['mascotas'] as $mascota_id) {
            if (!in_array($mascota_id, $mascotasDelCliente)) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ Error: Una o más mascotas no pertenecen a este cliente',
                ], 422);
            }
        }

        // ========== CREAR CITA ==========
        $cita = Cita::create([
            'cliente_id' => $validated['cliente_id'],
            'fecha_hora_inicio' => $validated['fecha'] . ' ' . $validated['hora'],
            'motivo' => $validated['motivo'],
            'notas_internas' => $validated['notas'] ?? null,
            'estado' => 'pendiente', // Estado automático
            'user_id' => $user->id,
        ]);

        // ========== ASOCIAR MASCOTAS ==========
        $cita->mascotas()->attach($validated['mascotas']);

        // ========== GENERAR MENSAJE WHATSAPP (Fase 3) ==========
        // Inicializar valores por defecto ANTES del try/catch
        $datosWhatsApp = [
            'enlace_whatsapp' => '',
            'mensaje' => '',
        ];

        try {
            $cita->load('cliente'); // Cargar relación
            $datosWhatsApp = WhatsAppMessageService::generarMensajeCita($cita, $user);

            $cita->update([
                'mensaje_whatsapp' => $datosWhatsApp['mensaje'],
                'enlace_whatsapp' => $datosWhatsApp['enlace_whatsapp'],
            ]);
        } catch (\Exception $e) {
            // Si hay error en WhatsApp, registrarlo pero continuar
            \Log::error('Error generando WhatsApp: ' . $e->getMessage());
        }

        // ========== RESPUESTA ==========
        return response()->json([
            'success' => true,
            'message' => '✅ Cita creada exitosamente',
            'cita' => [
                'id' => $cita->id,
                'cliente' => $cita->cliente->nombre,
                'mascotas' => $cita->mascotas->pluck('nombre'),
                'fecha' => $cita->fecha_hora_inicio->format('d/m/Y H:i'),
                'motivo' => $cita->motivo,
                'estado' => $cita->estado,
                'whatsapp' => [
                    'enlace' => $datosWhatsApp['enlace_whatsapp'],
                    'mensaje' => $datosWhatsApp['mensaje'],
                ]
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cita $cita)
    {
        $this->authorize('view', $cita);
        $cita->load(['cliente', 'mascotas']);
        return view('citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cita $cita)
    {
        $this->authorize('update', $cita);
        $cita->load(['cliente', 'mascotas']);
        
        $user = Auth::user();
        $max_mascotas = $user->getConfig('max_mascotas', 3);

        return view('citas.edit', compact('cita', 'max_mascotas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cita $cita)
    {
        $this->authorize('update', $cita);

        $user = Auth::user();
        $max_mascotas = $user->getConfig('max_mascotas', 3);

        $validated = $request->validate([
            'cliente_id' => 'required|integer|exists:clientes,id',
            'mascotas' => 'required|array|min:1|max:' . $max_mascotas,
            'mascotas.*' => 'integer|exists:mascotas,id',
            'fecha' => 'required|date_format:Y-m-d',
            'hora' => 'required|date_format:H:i',
            'motivo' => 'required|string|max:255',
            'notas' => 'nullable|string|max:1000',
            'estado' => 'required|in:pendiente,confirmada,completada',
        ]);

        // Actualizar cita
        $cita->update([
            'cliente_id' => $validated['cliente_id'],
            'fecha_hora_inicio' => $validated['fecha'] . ' ' . $validated['hora'],
            'motivo' => $validated['motivo'],
            'notas_internas' => $validated['notas'],
            'estado' => $validated['estado'],
        ]);

        // Actualizar mascotas
        $cita->mascotas()->sync($validated['mascotas']);

        // Regenerar mensaje WhatsApp
        WhatsAppMessageService::actualizarMensajeCita($cita);

        return response()->json([
            'success' => true,
            'message' => '✅ Cita actualizada exitosamente',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cita $cita)
    {
        $this->authorize('delete', $cita);
        
        $cita->mascotas()->detach();
        $cita->delete();

        return response()->json([
            'success' => true,
            'message' => '🗑️ Cita eliminada exitosamente',
        ]);
    }

    /**
     * ========== APIs PARA AJAX ==========
     */

    /**
     * Búsqueda avanzada de clientes (AJAX)
     * GET /api/buscar-clientes?q=búsqueda
     * 
     * Reutiliza la lógica del ClienteController
     * Con debounce de 300ms en el frontend
     */
    public function buscarClientes(Request $request)
    {
        $busqueda = trim($request->input('q', ''));
        $user = Auth::user();

        // Si la búsqueda es muy corta, no buscar
        if (strlen($busqueda) < 2) {
            return response()->json([]);
        }

        $query = Cliente::with('mascotas')
            ->where('veterinaria_id', $user->veterinaria_id);

        // Búsqueda avanzada (nombre, teléfono, mascota)
        $query->where(function ($q) use ($busqueda) {
            $q->where('nombre', 'LIKE', '%' . $busqueda . '%')
              ->orWhere('telefono', 'LIKE', '%' . $busqueda . '%')
              ->orWhereHas('mascotas', function ($queryMascota) use ($busqueda) {
                  $queryMascota->where('nombre', 'LIKE', '%' . $busqueda . '%');
              });
        });

        // Ordenamiento inteligente (exactas primero)
        $query->orderByRaw("
            CASE 
                WHEN nombre LIKE ? THEN 1 
                WHEN telefono LIKE ? THEN 2
                ELSE 3 
            END ASC
        ", ["{$busqueda}%", "{$busqueda}%"]);

        // Limitar a 5 resultados (optimización)
        $clientes = $query->limit(5)->get();

        return response()->json(
            $clientes->map(function ($cliente) {
                return [
                    'id' => $cliente->id,
                    'nombre' => $cliente->nombre,
                    'email' => $cliente->email,
                    'telefono' => $cliente->telefono,
                    'mascotas_count' => $cliente->mascotas->count(),
                    'mascotas' => $cliente->mascotas->map(fn($m) => [
                        'id' => $m->id,
                        'nombre' => $m->nombre,
                        'especie' => $m->especie,
                    ]),
                ];
            })
        );
    }

    /**
     * Obtener mascotas de un cliente (AJAX)
     * GET /api/cliente/{clienteId}/mascotas
     */
    public function mascotasDelCliente($clienteId)
{
    $user = Auth::user();

    // Debug: Ver qué mascotas existen
    \Log::info('Buscando mascotas del cliente: ' . $clienteId . ' en veterinaria: ' . $user->veterinaria_id);

    // ✅ Cargar mascotas sin global scope para debug
    $mascotas = Mascota::withoutGlobalScopes()
        ->where('cliente_id', $clienteId)
        ->where('veterinaria_id', $user->veterinaria_id)
        ->select('id', 'nombre', 'especie', 'raza', 'edad')
        ->get();

    \Log::info('Mascotas encontradas: ' . $mascotas->count());

    return response()->json($mascotas);
}

    /**
     * Obtener configuración de la veterinaria (AJAX)
     * GET /api/veterinaria/config
     */
    public function obtenerConfig()
    {
        $user = Auth::user();
        $max_mascotas = $user->getConfig('max_mascotas', 3);

        return response()->json([
            'max_mascotas' => $max_mascotas,
            'nombre_veterinaria' => $user->name,
        ]);
    }

    /**
     * Enviar mensaje WhatsApp (AJAX)
     * POST /citas/{cita}/enviar-whatsapp
     */
    public function enviarWhatsApp(Cita $cita)
    {
        $this->authorize('update', $cita);

        if (!$cita->enlace_whatsapp) {
            return response()->json([
                'success' => false,
                'message' => '❌ No hay mensaje WhatsApp generado',
            ], 400);
        }

        // Marcar como enviado
        $cita->update([
            'whatsapp_enviado' => true,
            'fecha_envio_whatsapp' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => '✅ Redirigiendo a WhatsApp...',
            'enlace' => $cita->enlace_whatsapp,
        ]);
    }
}