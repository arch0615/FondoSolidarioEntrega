<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Message;

class EmailService
{
    /**
     * Footer estándar para correos de notificación no-reply
     */
    private static function getFooterEstandar(): string
    {
        return "
        <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
        <div style='font-size: 12px; color: #666; text-align: center; padding: 10px;'>
            <p><strong>Este es un correo automático de notificación del Sistema Fondo Solidario JAEC.</strong></p>
            <p>Por favor, <strong>NO RESPONDA</strong> a este correo electrónico. Este buzón no es monitoreado.</p>
            <p>Si necesita asistencia, contacte al administrador del sistema a través de los canales oficiales.</p>
            <p style='margin-top: 15px; font-size: 11px;'>
                © " . date('Y') . " Fondo Solidario JAEC - Todos los derechos reservados
            </p>
        </div>";
    }

    /**
     * Envía un correo a un usuario específico por su ID
     *
     * @param int $userId ID del usuario destinatario
     * @param string $asunto Asunto del correo
     * @param string $cuerpo Cuerpo del mensaje (HTML)
     * @param array $opciones Opciones adicionales (remitente personalizado, etc.)
     * @return array Resultado del envío
     */
    public static function enviarPorUsuario(int $userId, string $asunto, string $cuerpo, array $opciones = []): array
    {
        try {
            $usuario = User::where('id_usuario', $userId)
                          ->where('activo', true)
                          ->first();

            if (!$usuario) {
                return [
                    'exito' => false,
                    'mensaje' => "Usuario con ID {$userId} no encontrado o inactivo",
                    'correos_enviados' => 0,
                    'errores' => ["Usuario no encontrado"]
                ];
            }

            return self::enviarCorreo(collect([$usuario]), $asunto, $cuerpo, $opciones);

        } catch (\Exception $e) {
            Log::error("Error en enviarPorUsuario", [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);

            return [
                'exito' => false,
                'mensaje' => 'Error al enviar correo: ' . $e->getMessage(),
                'correos_enviados' => 0,
                'errores' => [$e->getMessage()]
            ];
        }
    }

    /**
     * Envía un correo a todos los usuarios de un rol específico
     *
     * @param int|string $rol ID del rol o nombre del rol
     * @param string $asunto Asunto del correo
     * @param string $cuerpo Cuerpo del mensaje (HTML)
     * @param array $opciones Opciones adicionales
     * @return array Resultado del envío
     */
    public static function enviarPorRol($rol, string $asunto, string $cuerpo, array $opciones = []): array
    {
        try {
            $usuarios = collect();

            if (is_numeric($rol)) {
                // Buscar por ID de rol
                $usuarios = User::where('id_rol', $rol)
                              ->where('activo', true)
                              ->get();
            } else {
                // Buscar por nombre de rol
                $rolModel = Role::where('nombre_rol', $rol)
                              ->where('activo', true)
                              ->first();

                if ($rolModel) {
                    $usuarios = User::where('id_rol', $rolModel->id_rol)
                                  ->where('activo', true)
                                  ->get();
                }
            }

            if ($usuarios->isEmpty()) {
                return [
                    'exito' => false,
                    'mensaje' => "No se encontraron usuarios activos para el rol: {$rol}",
                    'correos_enviados' => 0,
                    'errores' => ["No hay usuarios con ese rol"]
                ];
            }

            return self::enviarCorreo($usuarios, $asunto, $cuerpo, $opciones);

        } catch (\Exception $e) {
            Log::error("Error en enviarPorRol", [
                'rol' => $rol,
                'error' => $e->getMessage()
            ]);

            return [
                'exito' => false,
                'mensaje' => 'Error al enviar correos por rol: ' . $e->getMessage(),
                'correos_enviados' => 0,
                'errores' => [$e->getMessage()]
            ];
        }
    }

    /**
     * Envía correos a múltiples usuarios
     *
     * @param \Illuminate\Support\Collection $usuarios Colección de usuarios
     * @param string $asunto Asunto del correo
     * @param string $cuerpo Cuerpo del mensaje (HTML)
     * @param array $opciones Opciones adicionales
     * @return array Resultado del envío
     */
    private static function enviarCorreo($usuarios, string $asunto, string $cuerpo, array $opciones = []): array
    {
        $inicio = microtime(true);
        $correos_enviados = 0;
        $errores = [];
        $total_usuarios = $usuarios->count();

        // Configurar timeouts para el envío
        self::configurarTimeouts();

        // Verificar conexión SMTP antes de proceder
        if (!self::verificarConexionSMTP()) {
            return [
                'exito' => false,
                'correos_enviados' => 0,
                'total_usuarios' => $total_usuarios,
                'errores' => ['Conexión SMTP fallida'],
                'mensaje' => 'No se puede conectar al servidor de correo',
                'tiempo_ejecucion' => round(microtime(true) - $inicio, 2)
            ];
        }

        // Preparar el cuerpo completo con footer
        $cuerpoCompleto = $cuerpo . self::getFooterEstandar();

        // Configurar remitente
        $fromAddress = $opciones['from_address'] ?? config('mail.from.address');
        $fromName = $opciones['from_name'] ?? config('mail.from.name');

        foreach ($usuarios as $usuario) {
            $inicioEnvio = microtime(true);
            
            try {
                // Configurar timeout específico para este envío
                set_time_limit(35); // 30s timeout + 5s buffer
                
                Mail::html($cuerpoCompleto, function (Message $message) use ($usuario, $asunto, $fromAddress, $fromName) {
                    $message->to($usuario->email, $usuario->nombre_completo ?? $usuario->nombre)
                           ->subject($asunto)
                           ->from($fromAddress, $fromName);
                });

                $correos_enviados++;
                $tiempoEnvio = round(microtime(true) - $inicioEnvio, 2);

                Log::info("Correo enviado exitosamente", [
                    'destinatario' => $usuario->email,
                    'asunto' => $asunto,
                    'usuario_id' => $usuario->id_usuario,
                    'rol_id' => $usuario->id_rol,
                    'tiempo_envio' => $tiempoEnvio . 's'
                ]);

            } catch (\Exception $e) {
                $tiempoEnvio = round(microtime(true) - $inicioEnvio, 2);
                $error = "Error enviando correo a {$usuario->email}: " . $e->getMessage();
                $errores[] = $error;

                Log::error("Error enviando correo", [
                    'destinatario' => $usuario->email,
                    'usuario_id' => $usuario->id_usuario,
                    'error' => $e->getMessage(),
                    'tiempo_intento' => $tiempoEnvio . 's',
                    'tipo_error' => self::clasificarError($e)
                ]);

                // Si es un error crítico, detener el proceso
                if (self::esErrorCritico($e)) {
                    Log::error("Error crítico detectado, deteniendo envío de correos", [
                        'error_tipo' => self::clasificarError($e)
                    ]);
                    break;
                }
            }
        }

        $tiempoTotal = round(microtime(true) - $inicio, 2);

        // Log del resultado general con métricas de rendimiento
        Log::info("Proceso de envío de correos completado", [
            'correos_enviados' => $correos_enviados,
            'errores' => count($errores),
            'total_usuarios' => $total_usuarios,
            'asunto' => $asunto,
            'tiempo_total' => $tiempoTotal . 's',
            'promedio_por_correo' => $correos_enviados > 0 ? round($tiempoTotal / $correos_enviados, 2) . 's' : 'N/A'
        ]);

        return [
            'exito' => $correos_enviados > 0,
            'correos_enviados' => $correos_enviados,
            'total_usuarios' => $total_usuarios,
            'errores' => $errores,
            'tiempo_ejecucion' => $tiempoTotal,
            'mensaje' => $correos_enviados > 0
                ? "Se enviaron {$correos_enviados} de {$total_usuarios} correos en {$tiempoTotal}s"
                : "No se pudo enviar ningún correo"
        ];
    }

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
     * Obtiene la lista de usuarios por rol para verificación
     *
     * @param int|string $rol ID del rol o nombre del rol
     * @return \Illuminate\Support\Collection
     */
    public static function obtenerUsuariosPorRol($rol)
    {
        if (is_numeric($rol)) {
            return User::where('id_rol', $rol)
                      ->where('activo', true)
                      ->select('id_usuario', 'email', 'nombre', 'apellido', 'id_rol')
                      ->get();
        } else {
            $rolModel = Role::where('nombre_rol', $rol)->first();
            if ($rolModel) {
                return User::where('id_rol', $rolModel->id_rol)
                          ->where('activo', true)
                          ->select('id_usuario', 'email', 'nombre', 'apellido', 'id_rol')
                          ->get();
            }
        }

        return collect();
    }

    /**
     * Obtiene información de un usuario por ID
     *
     * @param int $userId
     * @return User|null
     */
    public static function obtenerUsuario(int $userId)
    {
        return User::where('id_usuario', $userId)
                  ->where('activo', true)
                  ->select('id_usuario', 'email', 'nombre', 'apellido', 'id_rol')
                  ->first();
    }

    /**
     * Valida que las credenciales de correo estén configuradas
     *
     * @return array
     */
    public static function validarConfiguracion(): array
    {
        $errores = [];

        if (empty(config('mail.mailers.smtp.host'))) {
            $errores[] = 'MAIL_HOST no está configurado';
        }

        if (empty(config('mail.mailers.smtp.username'))) {
            $errores[] = 'MAIL_USERNAME no está configurado';
        }

        if (empty(config('mail.mailers.smtp.password'))) {
            $errores[] = 'MAIL_PASSWORD no está configurado';
        }

        if (empty(config('mail.from.address'))) {
            $errores[] = 'MAIL_FROM_ADDRESS no está configurado';
        }

        return [
            'valido' => empty($errores),
            'errores' => $errores
        ];
    }
}