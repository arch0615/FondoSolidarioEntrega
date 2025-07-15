<?php

namespace App\Services;

use App\Models\AuditoriaSistema;
use Illuminate\Support\Facades\Auth;

class AuditoriaService
{
    /**
     * Registrar inicio de sesión
     */
    public static function registrarLogin($usuario): void
    {
        AuditoriaSistema::registrarAccion(
            $usuario->id_usuario,
            'LOGIN',
            'usuarios',
            $usuario->id_usuario,
            null,
            [
                'email' => $usuario->email,
                'nombre' => $usuario->nombre_completo,
                'rol' => $usuario->rol_nombre,
                'fecha_acceso' => now()->format('Y-m-d H:i:s')
            ]
        );
    }

    /**
     * Registrar cierre de sesión
     */
    public static function registrarLogout($usuario): void
    {
        AuditoriaSistema::registrarAccion(
            $usuario->id_usuario,
            'LOGOUT',
            'usuarios',
            $usuario->id_usuario,
            [
                'email' => $usuario->email,
                'nombre' => $usuario->nombre_completo,
                'rol' => $usuario->rol_nombre,
                'fecha_salida' => now()->format('Y-m-d H:i:s')
            ],
            null
        );
    }

    /**
     * Registrar creación de registro
     */
    public static function registrarCreacion($tabla, $idRegistro, $datos, $usuario = null): void
    {
        $usuario = $usuario ?? Auth::user();
        
        if ($usuario) {
            AuditoriaSistema::registrarAccion(
                $usuario->id_usuario,
                'CREATE',
                $tabla,
                $idRegistro,
                null,
                $datos
            );
        }
    }

    /**
     * Registrar actualización de registro
     */
    public static function registrarActualizacion($tabla, $idRegistro, $datosAnteriores, $datosNuevos, $usuario = null): void
    {
        $usuario = $usuario ?? Auth::user();
        
        if ($usuario) {
            AuditoriaSistema::registrarAccion(
                $usuario->id_usuario,
                'UPDATE',
                $tabla,
                $idRegistro,
                $datosAnteriores,
                $datosNuevos
            );
        }
    }

    /**
     * Registrar eliminación de registro
     */
    public static function registrarEliminacion($tabla, $idRegistro, $datosEliminados, $usuario = null): void
    {
        $usuario = $usuario ?? Auth::user();
        
        if ($usuario) {
            AuditoriaSistema::registrarAccion(
                $usuario->id_usuario,
                'DELETE',
                $tabla,
                $idRegistro,
                $datosEliminados,
                null
            );
        }
    }

    /**
     * Registrar acceso a vista/consulta
     */
    public static function registrarConsulta($tabla, $filtros = null, $usuario = null): void
    {
        $usuario = $usuario ?? Auth::user();
        
        if ($usuario) {
            AuditoriaSistema::registrarAccion(
                $usuario->id_usuario,
                'VIEW',
                $tabla,
                null,
                null,
                $filtros ? ['filtros' => $filtros] : null
            );
        }
    }

    /**
     * Registrar acción personalizada
     */
    public static function registrarAccionPersonalizada($accion, $tabla, $idRegistro = null, $datos = null, $usuario = null): void
    {
        $usuario = $usuario ?? Auth::user();
        
        if ($usuario) {
            AuditoriaSistema::registrarAccion(
                $usuario->id_usuario,
                $accion,
                $tabla,
                $idRegistro,
                null,
                $datos
            );
        }
    }

    /**
     * Obtener historial de auditoría para un usuario
     */
    public static function obtenerHistorialUsuario($idUsuario, $limite = 50)
    {
        return AuditoriaSistema::where('id_usuario', $idUsuario)
            ->orderBy('fecha_hora', 'desc')
            ->limit($limite)
            ->get();
    }

    /**
     * Obtener historial de auditoría para una tabla específica
     */
    public static function obtenerHistorialTabla($tabla, $limite = 50)
    {
        return AuditoriaSistema::where('tabla_afectada', $tabla)
            ->orderBy('fecha_hora', 'desc')
            ->limit($limite)
            ->get();
    }

    /**
     * Obtener estadísticas de actividad
     */
    public static function obtenerEstadisticas($fechaInicio = null, $fechaFin = null)
    {
        $query = AuditoriaSistema::query();
        
        if ($fechaInicio) {
            $query->where('fecha_hora', '>=', $fechaInicio);
        }
        
        if ($fechaFin) {
            $query->where('fecha_hora', '<=', $fechaFin);
        }
        
        return [
            'total_acciones' => $query->count(),
            'acciones_por_tipo' => $query->selectRaw('accion, COUNT(*) as total')
                ->groupBy('accion')
                ->pluck('total', 'accion'),
            'usuarios_activos' => $query->distinct('id_usuario')->count('id_usuario'),
            'tablas_mas_utilizadas' => $query->selectRaw('tabla_afectada, COUNT(*) as total')
                ->whereNotNull('tabla_afectada')
                ->groupBy('tabla_afectada')
                ->orderByDesc('total')
                ->limit(10)
                ->pluck('total', 'tabla_afectada')
        ];
    }
}