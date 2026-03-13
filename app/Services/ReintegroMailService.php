<?php

namespace App\Services;

use App\Mail\NuevoReintegroMail;
use App\Mail\EstadoReintegroEscuelaMail;
use App\Models\Reintegro;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class ReintegroMailService
{
    /**
     * Timeout para conexiones SMTP (en segundos)
     */
    private static $timeout = 30;

    /**
     * Verifica la conexión SMTP antes de enviar correos
     */
    private static function verificarConexionSMTP(): bool
    {
        try {
            $host = config('mail.mailers.smtp.host');
            $port = config('mail.mailers.smtp.port', 587);
            
            if (empty($host)) {
                Log::warning("SMTP host no configurado");
                return false;
            }

            // Intentar conexión con timeout
            $connection = @fsockopen($host, $port, $errno, $errstr, self::$timeout);
            
            if (!$connection) {
                Log::warning("No se puede conectar al servidor SMTP", [
                    'host' => $host,
                    'port' => $port,
                    'error' => "$errstr ($errno)"
                ]);
                return false;
            }
            
            fclose($connection);
            return true;
            
        } catch (\Exception $e) {
            Log::warning("Error verificando conexión SMTP: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Configura timeouts para el envío de correos
     */
    private static function configurarTimeouts()
    {
        // Configurar timeout para conexiones de red
        ini_set('default_socket_timeout', self::$timeout);
        
        // Configurar timeout específico para SMTP si está disponible
        if (function_exists('stream_context_set_default')) {
            stream_context_set_default([
                'http' => [
                    'timeout' => self::$timeout
                ],
                'ssl' => [
                    'timeout' => self::$timeout
                ]
            ]);
        }
    }

    /**
     * Envía correos de notificación de nuevo reintegro a administradores y médicos auditores
     */
    public static function enviarNotificacionNuevoReintegro(Reintegro $reintegro)
    {
        $inicio = microtime(true);
        
        try {
            // 1. Configurar timeouts antes de cualquier operación de red
            self::configurarTimeouts();
            
            // 2. Verificar conexión SMTP antes de proceder
            if (!self::verificarConexionSMTP()) {
                return [
                    'exito' => false,
                    'mensaje' => 'No se puede conectar al servidor de correo. Verifique la configuración SMTP.',
                    'correos_enviados' => 0,
                    'total_usuarios' => 0,
                    'errores' => ['Conexión SMTP fallida'],
                    'tiempo_ejecucion' => round(microtime(true) - $inicio, 2)
                ];
            }

            // 3. Cargar TODAS las relaciones necesarias para el template de correo
            $reintegro->load([
                'alumno:id_alumno,nombre,apellido',  // Campos reales para el accessor nombre_completo
                'accidente:id_accidente,id_escuela,fecha_accidente,lugar_accidente,numero_accidente',
                'accidente.escuela:id_escuela,nombre',
                'usuarioSolicita:id_usuario,nombre,apellido',
                'estadoReintegro:id_estado_reintegro,descripcion',
                'tiposGastos:id_tipo_gasto,descripcion'
            ]);

            // 4. Obtener usuarios con consulta optimizada
            $usuariosNotificar = User::whereIn('id_rol', [2, 3]) // 2 = Administrador, 3 = Médico Auditor
                                    ->where('activo', true)
                                    ->select('id_usuario', 'email', 'nombre', 'apellido', 'id_rol')
                                    ->get();

            if ($usuariosNotificar->isEmpty()) {
                Log::warning("No hay usuarios activos para notificar sobre reintegro", [
                    'reintegro_id' => $reintegro->id_reintegro
                ]);
                
                return [
                    'exito' => false,
                    'mensaje' => 'No hay administradores o médicos auditores activos para notificar',
                    'correos_enviados' => 0,
                    'total_usuarios' => 0,
                    'errores' => ['No hay usuarios para notificar'],
                    'tiempo_ejecucion' => round(microtime(true) - $inicio, 2)
                ];
            }

            $correos_enviados = 0;
            $errores = [];

            // 5. Enviar correos con timeout individual por cada envío
            foreach ($usuariosNotificar as $usuario) {
                $inicioEnvio = microtime(true);
                
                try {
                    // Configurar timeout específico para este envío
                    set_time_limit(self::$timeout + 10); // Un poco más que el timeout de red
                    
                    Mail::to($usuario->email)->send(new NuevoReintegroMail($reintegro));
                    $correos_enviados++;
                    
                    $tiempoEnvio = round(microtime(true) - $inicioEnvio, 2);
                    
                    Log::info("Correo de nuevo reintegro enviado exitosamente", [
                        'reintegro_id' => $reintegro->id_reintegro,
                        'destinatario' => $usuario->email,
                        'rol' => $usuario->id_rol == 2 ? 'Administrador' : 'Médico Auditor',
                        'tiempo_envio' => $tiempoEnvio . 's'
                    ]);
                    
                } catch (\Exception $e) {
                    $tiempoEnvio = round(microtime(true) - $inicioEnvio, 2);
                    $error = "Error enviando correo a {$usuario->email}: " . $e->getMessage();
                    $errores[] = $error;
                    
                    Log::error("Error enviando correo de nuevo reintegro", [
                        'reintegro_id' => $reintegro->id_reintegro,
                        'destinatario' => $usuario->email,
                        'error' => $e->getMessage(),
                        'tiempo_intento' => $tiempoEnvio . 's',
                        'tipo_error' => self::clasificarError($e)
                    ]);
                    
                    // Si es un error de timeout o conexión, detener el proceso
                    if (self::esErrorCritico($e)) {
                        Log::error("Error crítico detectado, deteniendo envío de correos", [
                            'reintegro_id' => $reintegro->id_reintegro,
                            'error_tipo' => self::clasificarError($e)
                        ]);
                        break;
                    }
                }
            }

            $tiempoTotal = round(microtime(true) - $inicio, 2);

            // Log del resultado general con métricas de rendimiento
            Log::info("Proceso de envío de correos completado", [
                'reintegro_id' => $reintegro->id_reintegro,
                'correos_enviados' => $correos_enviados,
                'errores' => count($errores),
                'usuarios_objetivo' => $usuariosNotificar->count(),
                'tiempo_total' => $tiempoTotal . 's',
                'promedio_por_correo' => $correos_enviados > 0 ? round($tiempoTotal / $correos_enviados, 2) . 's' : 'N/A'
            ]);

            return [
                'exito' => $correos_enviados > 0,
                'correos_enviados' => $correos_enviados,
                'total_usuarios' => $usuariosNotificar->count(),
                'errores' => $errores,
                'tiempo_ejecucion' => $tiempoTotal,
                'mensaje' => $correos_enviados > 0
                    ? "Se enviaron {$correos_enviados} de {$usuariosNotificar->count()} correos en {$tiempoTotal}s"
                    : "No se pudo enviar ningún correo"
            ];

        } catch (\Exception $e) {
            $tiempoTotal = round(microtime(true) - $inicio, 2);
            
            Log::error("Error general en envío de correos de nuevo reintegro", [
                'reintegro_id' => $reintegro->id_reintegro,
                'error' => $e->getMessage(),
                'tiempo_hasta_error' => $tiempoTotal . 's',
                'tipo_error' => self::clasificarError($e)
            ]);

            return [
                'exito' => false,
                'mensaje' => 'Error general al enviar las notificaciones: ' . $e->getMessage(),
                'correos_enviados' => 0,
                'total_usuarios' => 0,
                'errores' => [$e->getMessage()],
                'tiempo_ejecucion' => $tiempoTotal
            ];
        }
    }

    /**
     * Clasifica el tipo de error para mejor diagnóstico
     */
    private static function clasificarError(\Exception $e): string
    {
        $mensaje = strtolower($e->getMessage());
        
        if (strpos($mensaje, 'timeout') !== false || strpos($mensaje, 'timed out') !== false) {
            return 'timeout';
        }
        
        if (strpos($mensaje, 'connection') !== false || strpos($mensaje, 'connect') !== false) {
            return 'conexion';
        }
        
        if (strpos($mensaje, 'authentication') !== false || strpos($mensaje, 'auth') !== false) {
            return 'autenticacion';
        }
        
        if (strpos($mensaje, 'smtp') !== false) {
            return 'smtp';
        }
        
        return 'general';
    }

    /**
     * Determina si un error es crítico y debe detener el proceso
     */
    private static function esErrorCritico(\Exception $e): bool
    {
        $tipo = self::clasificarError($e);
        return in_array($tipo, ['timeout', 'conexion']);
    }

    /**
     * Obtiene la lista de usuarios que recibirán las notificaciones
     */
    public static function obtenerUsuariosNotificacion()
    {
        return User::whereIn('id_rol', [2, 3]) // 2 = Administrador, 3 = Médico Auditor
                   ->where('activo', true)
                   ->select('id_usuario', 'email', 'nombre', 'apellido', 'id_rol')
                   ->get()
                   ->map(function ($usuario) {
                       return [
                           'id' => $usuario->id_usuario,
                           'email' => $usuario->email,
                           'nombre_completo' => $usuario->nombre . ' ' . $usuario->apellido,
                           'rol' => $usuario->id_rol == 2 ? 'Administrador' : 'Médico Auditor'
                       ];
                   });
    }

    /**
     * Envía una notificación por correo a todos los usuarios de la escuela asociada al reintegro.
     *
     * El correo incluye:
     * - Información básica del accidente (número de expediente, fecha, descripción/lugar)
     * - Información del reintegro (fecha solicitud, alumno, monto)
     * - Resultado de la acción (aprobación/rechazo/solicitud de información/mensaje) y detalle
     *
     * @param Reintegro $reintegro
     * @param string $resultado Texto corto que describe el resultado (ej. "Aprobación", "Rechazo", "Solicitud de Información", "Mensaje")
     * @param string $detalle Detalle adicional (motivo, observaciones o mensaje)
     * @return array
     */
    public static function enviarNotificacionEstadoAEscuela(Reintegro $reintegro, string $resultado, string $detalle = '')
    {
        $inicio = microtime(true);
        $correos_enviados = 0;
        $errores = [];
        // Inicializar colección de usuarios para evitar "Undefined variable" en catch
        $usuarios = collect();

        try {
            // Configurar timeouts y verificar SMTP
            self::configurarTimeouts();
            if (!self::verificarConexionSMTP()) {
                Log::warning("Conexión SMTP fallida al intentar notificar escuela para reintegro {$reintegro->id_reintegro}");
                return [
                    'exito' => false,
                    'correos_enviados' => 0,
                    'total_usuarios' => 0,
                    'errores' => ['Conexión SMTP fallida'],
                    'mensaje' => 'No se puede conectar al servidor de correo',
                    'tiempo_ejecucion' => round(microtime(true) - $inicio, 2)
                ];
            }

            // Cargar relaciones necesarias (evitar columnas inexistentes)
            $reintegro->load([
                'alumno:id_alumno,nombre,apellido',
                'accidente:id_accidente,id_escuela,fecha_accidente,lugar_accidente,descripcion_accidente',
                'accidente.escuela:id_escuela,nombre'
            ]);

            $escuelaId = $reintegro->accidente->id_escuela ?? $reintegro->accidente->escuela->id_escuela ?? null;
            if (!$escuelaId) {
                Log::warning("No se encontró escuela para reintegro {$reintegro->id_reintegro}");
                return [
                    'exito' => false,
                    'correos_enviados' => 0,
                    'total_usuarios' => 0,
                    'errores' => ['Escuela no encontrada'],
                    'mensaje' => 'No se encontró la escuela asociada al reintegro',
                    'tiempo_ejecucion' => round(microtime(true) - $inicio, 2)
                ];
            }

            // Obtener usuarios de la escuela (rol 1 = Usuario General)
            $usuarios = \App\Models\User::where('id_rol', 1)
                        ->where('id_escuela', $escuelaId)
                        ->where('activo', true)
                        ->select('id_usuario', 'email', 'nombre', 'apellido')
                        ->get();

            if ($usuarios->isEmpty()) {
                Log::warning("No hay usuarios activos en la escuela {$escuelaId} para notificar (reintegro {$reintegro->id_reintegro})");
                return [
                    'exito' => false,
                    'correos_enviados' => 0,
                    'total_usuarios' => 0,
                    'errores' => ['No hay usuarios en la escuela'],
                    'mensaje' => 'No se encontraron usuarios activos en la escuela para notificar',
                    'tiempo_ejecucion' => round(microtime(true) - $inicio, 2)
                ];
            }

            // Preparar asunto y cuerpo
            $asunto = "Estado del Reintegro REI-{$reintegro->id_reintegro}: {$resultado}";

            // Número de expediente: usar campos existentes
            $numeroExpe = $reintegro->accidente->numero_expediente ?? 'N/A';
            $fechaAcc = $reintegro->accidente->fecha_accidente ? \Carbon\Carbon::parse($reintegro->accidente->fecha_accidente)->format('d/m/Y H:i') : 'N/A';
            $descripcionAcc = $reintegro->accidente->descripcion_accidente ?? $reintegro->accidente->lugar_accidente ?? 'N/D';

            $fechaSolicitud = $reintegro->fecha_solicitud ? \Carbon\Carbon::parse($reintegro->fecha_solicitud)->format('d/m/Y') : 'N/A';
            $alumno = $reintegro->alumno->nombre_completo ?? ($reintegro->alumno->nombre . ' ' . $reintegro->alumno->apellido ?? 'N/D');
            $monto = isset($reintegro->monto_solicitado) ? number_format($reintegro->monto_solicitado, 2) : '0.00';

            $cuerpo = "<h2>Notificación de Reintegro - REI-{$reintegro->id_reintegro}</h2>";
            $cuerpo .= "<p><strong>Resultado:</strong> {$resultado}</p>";
            if (!empty($detalle)) {
                $cuerpo .= "<p><strong>Detalle:</strong> {$detalle}</p>";
            }
            $cuerpo .= "<h3>Información del Reintegro</h3>";
            $cuerpo .= "<ul>
                            <li><strong>Fecha solicitud:</strong> {$fechaSolicitud}</li>
                            <li><strong>Alumno:</strong> {$alumno}</li>
                            <li><strong>Monto:</strong> \${$monto}</li>
                        </ul>";
            $cuerpo .= "<h3>Información del Accidente</h3>";
            $cuerpo .= "<ul>
                            <li><strong>Número de expediente:</strong> {$numeroExpe}</li>
                            <li><strong>Fecha accidente:</strong> {$fechaAcc}</li>
                            <li><strong>Descripción/Lugar:</strong> {$descripcionAcc}</li>
                        </ul>";
            $cuerpo .= "<p>Para más detalles, ingrese al sistema: <a href=\"https://fondosolidario.jaeccba.org/\">Acceder al Sistema Fondo Solidario</a></p>";
            // Agregar footer estándar simple
            $cuerpo .= "<hr><p style='font-size:12px;color:#666;'>Este es un correo automático de Fondo Solidario JAEC. Por favor, no responda a este correo.</p>";

            // Determinar autor del cambio/mensaje si está disponible (para mostrar "Mensaje enviado por X")
            $autorNombre = null;
            try {
                if (Auth::check()) {
                    $u = Auth::user();
                    $autorNombre = trim((isset($u->nombre) ? $u->nombre : '') . ' ' . (isset($u->apellido) ? $u->apellido : ''));
                    if (empty($autorNombre)) {
                        $autorNombre = $u->name ?? $u->email ?? 'Sistema';
                    }
                }
            } catch (\Exception $e) {
                // no bloquear por errores de auth
                $autorNombre = null;
            }

            // Enviar a cada usuario usando Mailable profesional (misma identidad visual que "nuevo reintegro")
            foreach ($usuarios as $usuario) {
                try {
                    Mail::to($usuario->email)->send(new EstadoReintegroEscuelaMail($reintegro, $resultado, $detalle, $autorNombre));
                    $correos_enviados++;

                    Log::info("Correo de estado de reintegro enviado a usuario de la escuela", [
                        'reintegro_id' => $reintegro->id_reintegro,
                        'destinatario' => $usuario->email,
                        'usuario_id' => $usuario->id_usuario
                    ]);
                } catch (\Exception $e) {
                    $errores[] = "Error enviando correo a {$usuario->email}: " . $e->getMessage();
                    Log::error("Error enviando correo a usuario escuela", [
                        'reintegro_id' => $reintegro->id_reintegro,
                        'destinatario' => $usuario->email,
                        'error' => $e->getMessage(),
                        'tipo_error' => self::clasificarError($e)
                    ]);
                    if (self::esErrorCritico($e)) {
                        break;
                    }
                }
            }

            $tiempoTotal = round(microtime(true) - $inicio, 2);

            Log::info("Envió correos a usuarios de la escuela", [
                'reintegro_id' => $reintegro->id_reintegro,
                'escuela_id' => $escuelaId,
                'correos_enviados' => $correos_enviados,
                'errores' => count($errores),
                'tiempo_total' => $tiempoTotal . 's'
            ]);

            return [
                'exito' => $correos_enviados > 0,
                'correos_enviados' => $correos_enviados,
                'total_usuarios' => $usuarios->count(),
                'errores' => $errores,
                'tiempo_ejecucion' => $tiempoTotal,
                'mensaje' => $correos_enviados > 0 ? "Se enviaron {$correos_enviados} de {$usuarios->count()} correos" : "No se enviaron correos"
            ];

        } catch (\Exception $e) {
            $tiempoTotal = round(microtime(true) - $inicio, 2);
            Log::error("Error general al notificar por correo a la escuela", [
                'reintegro_id' => $reintegro->id_reintegro ?? null,
                'error' => $e->getMessage()
            ]);

            return [
                'exito' => false,
                'correos_enviados' => $correos_enviados,
                'total_usuarios' => isset($usuarios) ? $usuarios->count() : 0,
                'errores' => array_merge($errores, [$e->getMessage()]),
                'tiempo_ejecucion' => $tiempoTotal,
                'mensaje' => 'Error al enviar notificaciones por correo: ' . $e->getMessage()
            ];
        }
    }
}
