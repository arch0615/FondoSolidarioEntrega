<?php

namespace App\Services;

use App\Models\Notificacion;
use App\Models\User;
use App\Models\Reintegro;
use App\Models\Escuela;

class NotificationService
{
    /**
     * Crea una notificación para todos los usuarios de una escuela específica.
     *
     * @param int $escuelaId
     * @param string $titulo
     * @param string $mensaje
     * @param string $tipoEntidad
     * @param int $idEntidadReferencia
     */
    public static function notificarEscuela(int $escuelaId, string $titulo, string $mensaje, string $tipoEntidad, int $idEntidadReferencia)
    {
        $usuarios = User::where('id_escuela', $escuelaId)->get();

        foreach ($usuarios as $usuario) {
            Notificacion::create([
                'id_usuario_destino' => $usuario->id_usuario,
                'tipo_notificacion' => 'gestion',
                'titulo' => $titulo,
                'mensaje' => $mensaje,
                'id_entidad_referencia' => $idEntidadReferencia,
                'tipo_entidad' => $tipoEntidad,
                'fecha_creacion' => now(),
                'leida' => false,
            ]);
        }
    
    }

    /**
     * Crea una notificación para todos los usuarios con un rol específico.
     *
     * @param string $rolNombre
     * @param string $titulo
     * @param string $mensaje
     * @param string $tipoEntidad
     * @param int $idEntidadReferencia
     */
    public static function notificarRol(string $rolNombre, string $titulo, string $mensaje, string $tipoEntidad, int $idEntidadReferencia)
    {
        $rolId = \App\Models\Role::where('nombre_rol', $rolNombre)->first()->id_rol ?? null;
        
        if ($rolId) {
            $usuarios = User::where('id_rol', $rolId)->get();

            foreach ($usuarios as $usuario) {
                Notificacion::create([
                    'id_usuario_destino' => $usuario->id_usuario,
                    'tipo_notificacion' => 'gestion',
                    'titulo' => $titulo,
                    'mensaje' => $mensaje,
                    'id_entidad_referencia' => $idEntidadReferencia,
                    'tipo_entidad' => $tipoEntidad,
                    'fecha_creacion' => now(),
                    'leida' => false,
                ]);
            }
        }
    }

    /**
     * Crea una notificación para todos los administradores.
     *
     * @param string $titulo
     * @param string $mensaje
     * @param string $tipoEntidad
     * @param int $idEntidadReferencia
     */
    public static function notificarAdmins(string $titulo, string $mensaje, string $tipoEntidad, int $idEntidadReferencia)
    {
        $adminRoleId = \App\Models\Role::where('nombre_rol', 'Administrador')->first()->id_rol ?? null;
        
        if ($adminRoleId) {
            $admins = User::where('id_rol', $adminRoleId)->get();

            foreach ($admins as $admin) {
                Notificacion::create([
                    'id_usuario_destino' => $admin->id_usuario,
                    'tipo_notificacion' => 'gestion',
                    'titulo' => $titulo,
                    'mensaje' => $mensaje,
                    'id_entidad_referencia' => $idEntidadReferencia,
                    'tipo_entidad' => $tipoEntidad,
                    'fecha_creacion' => now(),
                    'leida' => false,
                ]);
            }
        }
    }
}