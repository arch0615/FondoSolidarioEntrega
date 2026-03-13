<?php

if (!function_exists('export_clean')) {
    /**
     * Limpia una cadena para exportación, asegurando la codificación UTF-8 correcta.
     *
     * @param string|null $string
     * @return string
     */
    function export_clean($string)
    {
        if ($string === null) {
            return '';
        }
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('enviar_correo_usuario')) {
    /**
     * Envía un correo a un usuario específico por su ID
     *
     * @param int $userId ID del usuario destinatario
     * @param string $asunto Asunto del correo
     * @param string $cuerpo Cuerpo del mensaje (HTML)
     * @param array $opciones Opciones adicionales
     * @return array Resultado del envío
     */
    function enviar_correo_usuario(int $userId, string $asunto, string $cuerpo, array $opciones = []): array
    {
        return \App\Services\EmailService::enviarPorUsuario($userId, $asunto, $cuerpo, $opciones);
    }
}

if (!function_exists('enviar_correo_rol')) {
    /**
     * Envía un correo a todos los usuarios de un rol específico
     *
     * @param int|string $rol ID del rol o nombre del rol
     * @param string $asunto Asunto del correo
     * @param string $cuerpo Cuerpo del mensaje (HTML)
     * @param array $opciones Opciones adicionales
     * @return array Resultado del envío
     */
    function enviar_correo_rol($rol, string $asunto, string $cuerpo, array $opciones = []): array
    {
        return \App\Services\EmailService::enviarPorRol($rol, $asunto, $cuerpo, $opciones);
    }
}

if (!function_exists('validar_configuracion_correo')) {
    /**
     * Valida que las credenciales de correo estén configuradas correctamente
     *
     * @return array
     */
    function validar_configuracion_correo(): array
    {
        return \App\Services\EmailService::validarConfiguracion();
    }
}