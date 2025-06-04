<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AuditoriaSistema;
use Illuminate\Support\Facades\Auth;

class AuditoriaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Solo registrar para usuarios autenticados y rutas específicas
        if (Auth::check() && $this->shouldAudit($request)) {
            $this->registrarAccion($request);
        }

        return $response;
    }

    /**
     * Determinar si la acción debe ser auditada
     */
    private function shouldAudit(Request $request): bool
    {
        $rutasAuditar = [
            'accidentes.*',
            'alumnos.*',
            'reintegros.*',
            'derivaciones.*',
            'usuarios.*',
        ];

        $ruta = $request->route()?->getName();
        
        foreach ($rutasAuditar as $patron) {
            if (fnmatch($patron, $ruta)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Registrar la acción en auditoría
     */
    private function registrarAccion(Request $request): void
    {
        $user = Auth::user();
        $metodo = $request->method();
        $ruta = $request->route()?->getName() ?? $request->path();

        $accion = match ($metodo) {
            'POST' => 'CREATE',
            'PUT', 'PATCH' => 'UPDATE',
            'DELETE' => 'DELETE',
            default => 'VIEW'
        };

        // Determinar tabla afectada basada en la ruta
        $tablaAfectada = $this->determinarTabla($ruta);

        AuditoriaSistema::registrarAccion(
            $user->id_usuario,
            $accion,
            $tablaAfectada,
            null, // ID del registro se puede obtener desde el response
            null, // Datos anteriores
            $request->except(['_token', 'password', 'password_confirmation'])
        );
    }

    /**
     * Determinar la tabla afectada basada en la ruta
     */
    private function determinarTabla(string $ruta): ?string
    {
        if (str_contains($ruta, 'accidentes')) return 'accidentes';
        if (str_contains($ruta, 'alumnos')) return 'alumnos';
        if (str_contains($ruta, 'reintegros')) return 'reintegros';
        if (str_contains($ruta, 'derivaciones')) return 'derivaciones';
        if (str_contains($ruta, 'usuarios')) return 'usuarios';
        
        return null;
    }
}