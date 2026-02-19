<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Mascota;
use App\Services\WhatsAppMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CitaController extends Controller
{
    /**
     * Dashboard de citas con estadísticas y filtros (Próximas vs Historial)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $ahora = \Carbon\Carbon::now(); // Usamos \ para asegurar que lo encuentre
        $hoy = \Carbon\Carbon::today();

        // 🧠 LÓGICA INTELIGENTE: Auto-completar citas confirmadas que ya pasaron (15 min de gracia)
        \App\Models\Cita::where('user_id', $user->id)
            ->where('estado', 'confirmada')
            ->where('fecha_hora_inicio', '<', $ahora->subMinutes(15))
            ->update(['estado' => 'completada']);

        // 1. Configurar la consulta base inteligente
        $query = \App\Models\Cita::with(['cliente', 'mascotas'])
            ->whereHas('cliente', function ($q) use ($user) {
                $q->where('veterinaria_id', $user->veterinaria_id);
            });

        // 🔍 LÓGICA DE BÚSQUEDA AVANZADA
        if ($request->has('search') && $request->search != '') {
            $busqueda = $request->search;
            $query->where(function($q) use ($busqueda) {
                $q->whereHas('cliente', function($c) use ($busqueda) {
                    $c->where('nombre', 'LIKE', "%{$busqueda}%")
                      ->orWhere('telefono', 'LIKE', "%{$busqueda}%");
                })
                ->orWhereHas('mascotas', function($m) use ($busqueda) {
                    $m->where('nombre', 'LIKE', "%{$busqueda}%");
                })
                ->orWhere('motivo', 'LIKE', "%{$busqueda}%");
            });
        }

        // 2. Filtro: ¿Historial o Próximas?
        if ($request->has('ver') && $request->ver == 'historial') {
            $query->where(function($q) use ($hoy) {
                $q->whereDate('fecha_hora_inicio', '<', $hoy)
                  ->orWhereIn('estado', ['cancelada', 'completada']);
            })->orderBy('fecha_hora_inicio', 'desc');
        } else {
            $query->whereDate('fecha_hora_inicio', '>=', $hoy)
                  ->whereIn('estado', ['pendiente', 'confirmada'])
                  ->orderBy('fecha_hora_inicio', 'asc');
        }

        $citas = $query->paginate(15);

        // 3. Estadísticas para el Dashboard de la Asistente
        $estadisticas = [
            'por_confirmar' => \App\Models\Cita::where('user_id', $user->id)
                ->where('estado', 'pendiente')
                ->whereDate('fecha_hora_inicio', '>=', $hoy)
                ->count(),
            'confirmadas_proximas' => \App\Models\Cita::where('user_id', $user->id)
                ->where('estado', 'confirmada')
                ->whereDate('fecha_hora_inicio', '>=', $hoy)
                ->count(),
            'atendidas_hoy' => \App\Models\Cita::where('user_id', $user->id)
                ->where('estado', 'completada')
                ->whereDate('fecha_hora_inicio', $hoy)
                ->count(),
        ];

        // IMPORTANTE: Este es el return que hace que la página NO salga en blanco
         return view('citas.index', compact('citas', 'estadisticas'))->with('ahora', \Carbon\Carbon::now());
    }
    /**
     * Formulario de creación
     */
    public function create()
    {
        $user = Auth::user();
        $max_mascotas = $user->getConfig('max_mascotas', 3);
        return view('citas.create', compact('max_mascotas'));
    }

    /**
     * Guarda la cita con BLOQUEO DE 30 MINUTOS
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $max_mascotas = $user->getConfig('max_mascotas', 3);
        $duracion_minutos = 30;

        $validated = $request->validate([
            'cliente_id' => 'required|integer|exists:clientes,id',
            'mascotas' => 'required|array|min:1|max:' . $max_mascotas,
            'mascotas.*' => 'integer|exists:mascotas,id',
            'fecha' => 'required|date_format:Y-m-d|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'motivo' => 'required|string|max:255',
            'notas' => 'nullable|string|max:1000',
        ]);

        // 🔥 ESCUDO ANTI-CHOQUE BIDIRECCIONAL
        $inicioSolicitado = Carbon::createFromFormat('Y-m-d H:i', $validated['fecha'] . ' ' . $validated['hora']);
        $rangoInicio = $inicioSolicitado->copy()->subMinutes($duracion_minutos - 1);
        $rangoFin = $inicioSolicitado->copy()->addMinutes($duracion_minutos - 1);

        $existeChoque = Cita::where('user_id', $user->id)
            ->where('estado', '!=', 'cancelada')
            ->whereBetween('fecha_hora_inicio', [
                $rangoInicio->format('Y-m-d H:i:s'),
                $rangoFin->format('Y-m-d H:i:s')
            ])
            ->exists();

        if ($existeChoque) {
            return response()->json([
                'success' => false,
                'message' => '❌ Error: Horario ocupado. Deja 30 minutos de espacio.',
            ], 422);
        }

        // Crear Cita
        $cita = Cita::create([
            'cliente_id' => $validated['cliente_id'],
            'fecha_hora_inicio' => $inicioSolicitado,
            'motivo' => $validated['motivo'],
            'notas_internas' => $validated['notas'] ?? null,
            'estado' => 'pendiente',
            'user_id' => $user->id,
        ]);

        $cita->mascotas()->attach($validated['mascotas']);

        // WhatsApp
        $datosWhatsApp = ['enlace_whatsapp' => '', 'mensaje' => ''];
        try {
            $cita->load('cliente'); 
            $datosWhatsApp = WhatsAppMessageService::generarMensajeCita($cita, $user);
            $cita->update([
                'mensaje_whatsapp' => $datosWhatsApp['mensaje'],
                'enlace_whatsapp' => $datosWhatsApp['enlace_whatsapp'],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error WhatsApp: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => '✅ Cita creada',
            'cita' => [
                'id' => $cita->id,
                'fecha' => $cita->fecha_hora_inicio->format('d/m/Y H:i'),
                'estado' => $cita->estado,
                'whatsapp' => [
                    'enlace' => $datosWhatsApp['enlace_whatsapp'],
                    'mensaje' => $datosWhatsApp['mensaje'],
                ]
            ],
        ], 201);
    }

    /**
     * Muestra detalles (Versión UNIFICADA)
     */
    public function show($id)
    {
        $cita = Cita::with(['cliente', 'mascotas'])->findOrFail($id);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json($cita);
        }

        if (view()->exists('citas.show')) {
            return view('citas.show', compact('cita'));
        }
        
        return response()->json($cita);
    }

    /**
     * Edición de cita
     */
    public function edit(Cita $cita)
    {
        $cita->load(['cliente', 'mascotas']);
        $user = Auth::user();
        $max_mascotas = $user->getConfig('max_mascotas', 3);
        return view('citas.edit', compact('cita', 'max_mascotas'));
    }

    /**
     * Actualizar cita
     */
    public function update(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);

        // CASO 1: Solo actualizar estado (Botones rápidos)
        if ($request->has('estado') && count($request->all()) <= 3) { 
            $cita->estado = $request->estado;
            $cita->save();
            return back()->with('success', 'Estado actualizado a: ' . $request->estado);
        }

        // CASO 2: Edición completa (Formulario)
        $user = Auth::user();
        $max_mascotas = $user->getConfig('max_mascotas', 3);
        
        $validated = $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'required|string',
            'estado' => 'required',
            'notas' => 'nullable',
            'mascotas' => 'array|max:' . $max_mascotas
        ]);
        
        // Actualizamos fecha/hora con bloqueo simple
        $nuevaFecha = Carbon::createFromFormat('Y-m-d H:i', $validated['fecha'] . ' ' . $validated['hora']);
        
        $cita->update([
            'fecha_hora_inicio' => $nuevaFecha,
            'motivo' => $validated['motivo'],
            'estado' => $validated['estado'],
            'notas_internas' => $validated['notas']
        ]);

        if($request->has('mascotas')){
            $cita->mascotas()->sync($request->mascotas);
        }
        
        return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente');
    }

    /**
     * Eliminar cita
     */
    public function destroy(Cita $cita)
    {
        $cita->mascotas()->detach();
        $cita->delete();
        return response()->json(['success' => true, 'message' => 'Cita eliminada']);
    }

    // --- MÉTODOS AJAX ---

    public function buscarClientes(Request $request)
    {
        $busqueda = trim($request->input('q', ''));
        if (strlen($busqueda) < 2) return response()->json([]);

        $user = Auth::user();
        $clientes = Cliente::where('veterinaria_id', $user->veterinaria_id)
            ->where('nombre', 'LIKE', "%{$busqueda}%")
            ->limit(5)->get();

        return response()->json($clientes);
    }

    public function mascotasDelCliente($clienteId)
    {
        $mascotas = Mascota::where('cliente_id', $clienteId)->get();
        return response()->json($mascotas);
    }
}