<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\User;

class WhatsAppMessageService
{
    /**
     * Generar mensaje de WhatsApp formateado
     * 
     * @param Cita $cita
     * @param User $user - Usuario autenticado (propietario de la sucursal)
     * @return array - Contiene 'mensaje' y 'enlace_whatsapp'
     */
    public static function generarMensajeCita(Cita $cita, User $user): array
    {
        try {
            // Obtener datos de la cita
            $cliente = $cita->cliente;
            $mascotas = $cita->mascotas->pluck('nombre')->join(' y ');
            $fecha = $cita->fecha_hora_inicio->format('d/m/Y');
            $hora = $cita->fecha_hora_inicio->format('H:i');
            
            // Obtener datos de la sucursal desde la configuración del usuario
            $sucursal = self::obtenerDatosSucursal($user);
            
            // Construir mensaje
            $mensaje = self::construirMensaje(
                nombreCliente: $cliente->nombre,
                mascotas: $mascotas,
                fecha: $fecha,
                hora: $hora,
                sucursal: $sucursal
            );
            
            // Generar enlace WhatsApp
            $telefono = $cliente->telefono ?? '';
            $enlaceWhatsApp = self::generarEnlaceWhatsApp(
                telefono: $telefono,
                mensaje: $mensaje
            );
            
            return [
                'mensaje' => $mensaje,
                'enlace_whatsapp' => $enlaceWhatsApp,
                'telefono' => $telefono,
                'sucursal' => $sucursal
            ];
        } catch (\Exception $e) {
            // Si hay error, retornar valores por defecto
            return [
                'mensaje' => 'Error generando mensaje',
                'enlace_whatsapp' => '',
                'telefono' => '',
                'sucursal' => []
            ];
        }
    }
    
    /**
     * Construir mensaje de cita formateado
     */
    private static function construirMensaje(
        string $nombreCliente,
        string $mascotas,
        string $fecha,
        string $hora,
        array $sucursal
    ): string
    {
        $nombreSucursal = $sucursal['nombre'] ?? 'Nuestra Clínica Veterinaria';
        
        return <<<EOT
¡Hola $nombreCliente! 👋

Confirma tu cita veterinaria con nosotros.

🏥 *$nombreSucursal*
🐾 *Paciente(s):* $mascotas
📅 *Fecha:* $fecha
⏰ *Hora:* $hora

Por favor, llega 10 minutos antes.
¡Esperamos verte! 🐶🐱
EOT;
    }
    
    /**
     * Generar enlace de WhatsApp con mensaje preformateado
     * 
     * @param string $telefono - Número de teléfono con código país (ej: 529876543210)
     * @param string $mensaje - Mensaje a enviar
     * @return string - URL de WhatsApp
     */
    public static function generarEnlaceWhatsApp(string $telefono, string $mensaje): string
    {
        // Sanitizar teléfono: eliminar espacios, guiones, paréntesis
        $telefonoLimpio = preg_replace('/[^0-9+]/', '', $telefono);
        
        // Si no tiene código país, asumir México (+52)
        if (!str_starts_with($telefonoLimpio, '+') && !str_starts_with($telefonoLimpio, '52')) {
            $telefonoLimpio = '52' . ltrim($telefonoLimpio, '0');
        } elseif (!str_starts_with($telefonoLimpio, '+')) {
            $telefonoLimpio = '+' . $telefonoLimpio;
        }
        
        // Codificar mensaje para URL
        $mensajeCodificado = urlencode($mensaje);
        
        // Retornar enlace de WhatsApp Web API
        return "https://wa.me/{$telefonoLimpio}?text={$mensajeCodificado}";
    }
    
    /**
     * Obtener datos de la sucursal desde configuración del usuario
     */
    private static function obtenerDatosSucursal(User $user): array
    {
        $config = $user->configuracion ?? [];
        
        return [
            'nombre' => $config['sucursal_nombre'] ?? 'Clínica Veterinaria',
            'telefono' => $config['sucursal_telefono'] ?? '',
            'direccion' => $config['sucursal_direccion'] ?? '',
        ];
    }
    
    /**
     * Actualizar mensaje en una cita existente
     */
    public static function actualizarMensajeCita(Cita $cita): void
    {
        try {
            $user = auth()->user();
            if ($user) {
                $datos = self::generarMensajeCita($cita, $user);
                
                // Guardar en la cita
                $cita->update([
                    'mensaje_whatsapp' => $datos['mensaje'],
                    'enlace_whatsapp' => $datos['enlace_whatsapp'],
                ]);
            }
        } catch (\Exception $e) {
            // Si hay error, no hacer nada
            \Log::error('Error actualizando mensaje WhatsApp: ' . $e->getMessage());
        }
    }
}