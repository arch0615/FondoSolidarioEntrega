<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AuditoriaSistema;
use App\Models\User;
use App\Services\AuditoriaService;

class ConsultarAuditoria extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auditoria:consultar 
                            {--usuario= : ID del usuario para filtrar}
                            {--tabla= : Nombre de la tabla para filtrar}
                            {--accion= : Tipo de acción para filtrar (LOGIN, LOGOUT, CREATE, etc.)}
                            {--limite=20 : Número máximo de registros a mostrar}
                            {--estadisticas : Mostrar estadísticas de auditoría}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consultar registros de auditoría del sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('estadisticas')) {
            $this->mostrarEstadisticas();
            return;
        }

        $query = AuditoriaSistema::with('usuario');

        // Aplicar filtros
        if ($usuario = $this->option('usuario')) {
            $query->where('id_usuario', $usuario);
        }

        if ($tabla = $this->option('tabla')) {
            $query->where('tabla_afectada', $tabla);
        }

        if ($accion = $this->option('accion')) {
            $query->where('accion', strtoupper($accion));
        }

        $limite = $this->option('limite');
        $registros = $query->orderBy('fecha_hora', 'desc')
                          ->limit($limite)
                          ->get();

        if ($registros->isEmpty()) {
            $this->warn('No se encontraron registros de auditoría con los filtros aplicados.');
            return;
        }

        $this->info("Mostrando {$registros->count()} registros de auditoría:");
        $this->line('');

        $headers = ['ID', 'Usuario', 'Fecha/Hora', 'Acción', 'Tabla', 'ID Registro', 'IP'];
        $rows = [];

        foreach ($registros as $registro) {
            $usuario = $registro->usuario ? 
                "{$registro->usuario->nombre_completo} ({$registro->usuario->email})" : 
                "Usuario ID: {$registro->id_usuario}";

            $rows[] = [
                $registro->id_auditoria,
                $usuario,
                $registro->fecha_hora->format('Y-m-d H:i:s'),
                $registro->accion,
                $registro->tabla_afectada ?? 'N/A',
                $registro->id_registro ?? 'N/A',
                $registro->ip_usuario ?? 'N/A'
            ];
        }

        $this->table($headers, $rows);

        // Mostrar detalles del primer registro si hay datos
        if ($registros->first() && ($registros->first()->datos_anteriores || $registros->first()->datos_nuevos)) {
            $this->line('');
            $this->info('Detalles del primer registro:');
            
            if ($registros->first()->datos_anteriores) {
                $this->line('Datos anteriores: ' . $registros->first()->datos_anteriores);
            }
            
            if ($registros->first()->datos_nuevos) {
                $this->line('Datos nuevos: ' . $registros->first()->datos_nuevos);
            }
        }
    }

    /**
     * Mostrar estadísticas de auditoría
     */
    private function mostrarEstadisticas()
    {
        $this->info('📊 Estadísticas de Auditoría del Sistema');
        $this->line('');

        $estadisticas = AuditoriaService::obtenerEstadisticas();

        $this->info("📈 Total de acciones registradas: {$estadisticas['total_acciones']}");
        $this->info("👥 Usuarios activos: {$estadisticas['usuarios_activos']}");
        $this->line('');

        // Acciones por tipo
        $this->info('🔍 Acciones por tipo:');
        foreach ($estadisticas['acciones_por_tipo'] as $accion => $total) {
            $this->line("  - {$accion}: {$total}");
        }
        $this->line('');

        // Tablas más utilizadas
        $this->info('🗃️ Tablas más utilizadas:');
        foreach ($estadisticas['tablas_mas_utilizadas'] as $tabla => $total) {
            $this->line("  - {$tabla}: {$total}");
        }
        $this->line('');

        // Últimos logins
        $ultimosLogins = AuditoriaSistema::where('accion', 'LOGIN')
            ->with('usuario')
            ->orderBy('fecha_hora', 'desc')
            ->limit(5)
            ->get();

        if ($ultimosLogins->isNotEmpty()) {
            $this->info('🔐 Últimos 5 inicios de sesión:');
            foreach ($ultimosLogins as $login) {
                $usuario = $login->usuario ? 
                    $login->usuario->nombre_completo : 
                    "Usuario ID: {$login->id_usuario}";
                $this->line("  - {$usuario} - {$login->fecha_hora->format('Y-m-d H:i:s')} - IP: {$login->ip_usuario}");
            }
        }
    }
}