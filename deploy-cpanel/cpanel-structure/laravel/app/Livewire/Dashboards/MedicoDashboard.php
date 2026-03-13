<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Reintegro;
use App\Models\SolicitudInfoAuditor;
use App\Models\Alumno;
use App\Models\CatTipoGasto;
use App\Models\CatEstadoReintegro;
use Carbon\Carbon;

class MedicoDashboard extends Component
{
    public $stats = [];
    public $recentActivity = [];
    public $reintegrosPendientes = [];
    public $urgentes = [];

    // IDs de estados de reintegro
    public $estadoNuevoId;
    public $estadoPendienteInfoId;
    public $estadoAutorizadoId;
    public $estadoRechazadoId;
    public $estadoPagadoId;
    
    public function mount()
    {
        $this->loadEstadoIds();
        $this->loadStats();
        $this->loadRecentActivity();
        $this->loadReintegrosPendientes();
        $this->loadUrgentes();
    }

    private function loadEstadoIds()
    {
        $this->estadoNuevoId = CatEstadoReintegro::where('nombre_estado', 'En proceso')->first()->id_estado_reintegro ?? 1;
        $this->estadoPendienteInfoId = CatEstadoReintegro::where('nombre_estado', 'Requiere Información')->first()->id_estado_reintegro ?? 2;
        $this->estadoAutorizadoId = CatEstadoReintegro::where('nombre_estado', 'Autorizado')->first()->id_estado_reintegro ?? 3;
        $this->estadoRechazadoId = CatEstadoReintegro::where('nombre_estado', 'Rechazado')->first()->id_estado_reintegro ?? 4;
        $this->estadoPagadoId = CatEstadoReintegro::where('nombre_estado', 'Pagado')->first()->id_estado_reintegro ?? 5;
    }
    
    private function loadStats()
    {
        // Obtener datos reales de auditoría médica
        $hoy = Carbon::today();
        $inicioSemana = Carbon::now()->startOfWeek();
        $inicioMes = Carbon::now()->startOfMonth();
        $mesAnterior = Carbon::now()->subMonth()->startOfMonth();
        $finMesAnterior = Carbon::now()->subMonth()->endOfMonth();
        
        // Reintegros pendientes de auditoría (estado "En proceso")
        $pendientes = Reintegro::where('id_estado_reintegro', $this->estadoNuevoId)->count();
        $pendientesHoy = Reintegro::where('id_estado_reintegro', $this->estadoNuevoId)
            ->whereDate('fecha_solicitud', $hoy)->count();

        // Reintegros autorizados (estado "Autorizado")
        $autorizados = Reintegro::where('id_estado_reintegro', $this->estadoAutorizadoId)->count();
        $autorizadosSemana = Reintegro::where('id_estado_reintegro', $this->estadoAutorizadoId)
            ->where('fecha_autorizacion', '>=', $inicioSemana)->count();

        // Reintegros rechazados (estado "Rechazado")
        $rechazados = Reintegro::where('id_estado_reintegro', $this->estadoRechazadoId)->count();
        $rechazadosSemana = Reintegro::where('id_estado_reintegro', $this->estadoRechazadoId)
            ->where('fecha_auditoria', '>=', $inicioSemana)->count();
        
        // Reintegros que requieren información (estado "Requiere Información")
        $solicitudesInfo = Reintegro::where('id_estado_reintegro', $this->estadoPendienteInfoId)->count();
        
        // Tiempo promedio de revisión (en días)
        $tiempoPromedio = Reintegro::whereNotNull('fecha_auditoria')
            ->whereNotNull('fecha_solicitud')
            ->where('fecha_auditoria', '>=', $inicioMes)
            ->selectRaw('AVG(DATEDIFF(fecha_auditoria, fecha_solicitud)) as promedio')
            ->value('promedio');
        
        $tiempoPromedioMesAnterior = Reintegro::whereNotNull('fecha_auditoria')
            ->whereNotNull('fecha_solicitud')
            ->whereBetween('fecha_auditoria', [$mesAnterior, $finMesAnterior])
            ->selectRaw('AVG(DATEDIFF(fecha_auditoria, fecha_solicitud)) as promedio')
            ->value('promedio');
        
        $tiempoPromedio = round($tiempoPromedio ?? 0, 1);
        $diferenciaTiempo = $tiempoPromedioMesAnterior ? round($tiempoPromedio - $tiempoPromedioMesAnterior, 1) : 0;
        $iconoTiempo = $diferenciaTiempo <= 0 ? '↓' : '↑';
        
        $this->stats = [
            'reintegros_pendientes' => [
                'total' => $pendientes,
                'incremento' => $pendientesHoy > 0 ? "↑ {$pendientesHoy} nuevos hoy" : 'Sin nuevos hoy',
                'color' => 'amber'
            ],
            'reintegros_autorizados' => [
                'total' => $autorizados,
                'incremento' => $autorizadosSemana > 0 ? "↑ {$autorizadosSemana} esta semana" : 'Sin nuevos esta semana',
                'color' => 'green'
            ],
            'reintegros_rechazados' => [
                'total' => $rechazados,
                'incremento' => $rechazadosSemana > 0 ? "↑ {$rechazadosSemana} esta semana" : 'Sin nuevos esta semana',
                'color' => 'red'
            ],
            'solicitudes_informacion' => [
                'total' => $solicitudesInfo,
                'incremento' => $solicitudesInfo > 0 ? "{$solicitudesInfo} requieren información" : 'Sin pendientes de información',
                'color' => 'blue'
            ],
            'tiempo_promedio_revision' => [
                'total' => "{$tiempoPromedio} días",
                'incremento' => $diferenciaTiempo != 0 ? "{$iconoTiempo} " . abs($diferenciaTiempo) . " días vs mes anterior" : 'Sin cambios',
                'color' => 'indigo'
            ]
        ];
    }
    
    private function loadRecentActivity()
    {
        // Obtener actividad reciente médica real
        $actividades = collect();
        
        // Reintegros autorizados recientes
        $autorizados = Reintegro::with(['accidente.escuela', 'alumno'])
            ->where('id_estado_reintegro', $this->estadoAutorizadoId)
            ->whereNotNull('fecha_autorizacion')
            ->orderBy('fecha_autorizacion', 'desc')
            ->limit(2)
            ->get();
            
        foreach ($autorizados as $reintegro) {
            $actividades->push([
                'tipo' => 'autorizacion',
                'titulo' => 'Reintegro autorizado',
                'descripcion' => ($reintegro->accidente->escuela->nombre_escuela ?? 'Escuela') . ' - ' .
                               ($reintegro->alumno->nombre_completo ?? 'Alumno') . ' - $' . number_format($reintegro->monto_autorizado, 0),
                'tiempo' => $this->formatearTiempo($reintegro->fecha_autorizacion),
                'icono' => 'fas fa-check-circle',
                'color' => 'green',
                'fecha_orden' => $reintegro->fecha_autorizacion
            ]);
        }
        
        // Solicitudes de información recientes
        $solicitudes = SolicitudInfoAuditor::with(['reintegro.accidente.escuela'])
            ->where('id_estado_solicitud', 1)
            ->orderBy('fecha_solicitud', 'desc')
            ->limit(2)
            ->get();
            
        foreach ($solicitudes as $solicitud) {
            $actividades->push([
                'tipo' => 'solicitud_info',
                'titulo' => 'Información solicitada',
                'descripcion' => ($solicitud->reintegro->accidente->escuela->nombre_escuela ?? 'Escuela') . ' - ' .
                               substr($solicitud->descripcion_solicitud, 0, 50) . '...',
                'tiempo' => $this->formatearTiempo($solicitud->fecha_solicitud),
                'icono' => 'fas fa-info-circle',
                'color' => 'blue',
                'fecha_orden' => $solicitud->fecha_solicitud
            ]);
        }
        
        // Reintegros rechazados recientes
        $rechazados = Reintegro::with(['accidente.escuela', 'alumno'])
            ->where('id_estado_reintegro', $this->estadoRechazadoId)
            ->whereNotNull('fecha_auditoria')
            ->orderBy('fecha_auditoria', 'desc')
            ->limit(2)
            ->get();
            
        foreach ($rechazados as $reintegro) {
            $actividades->push([
                'tipo' => 'rechazo',
                'titulo' => 'Reintegro rechazado',
                'descripcion' => ($reintegro->accidente->escuela->nombre_escuela ?? 'Escuela') . ' - ' .
                               ($reintegro->observaciones_auditor ? substr($reintegro->observaciones_auditor, 0, 50) . '...' : 'Sin observaciones'),
                'tiempo' => $this->formatearTiempo($reintegro->fecha_auditoria),
                'icono' => 'fas fa-times-circle',
                'color' => 'red',
                'fecha_orden' => $reintegro->fecha_auditoria
            ]);
        }
        
        // Ordenar por fecha más reciente y tomar solo los últimos 4
        $this->recentActivity = $actividades->sortByDesc('fecha_orden')->take(4)->values()->toArray();
    }
    
    private function loadReintegrosPendientes()
    {
        // Obtener reintegros pendientes de autorización reales
        $pendientes = Reintegro::with(['accidente.escuela', 'alumno', 'tipoGasto'])
            ->where('id_estado_reintegro', $this->estadoNuevoId) // Estado "En proceso"
            ->orderBy('fecha_solicitud', 'asc')
            ->limit(5)
            ->get();
            
        $this->reintegrosPendientes = $pendientes->map(function ($reintegro) {
            return [
                'id' => 'REI-' . str_pad($reintegro->id_reintegro, 6, '0', STR_PAD_LEFT),
                'escuela' => $reintegro->accidente->escuela->nombre_escuela ?? 'Escuela no disponible',
                'alumno' => $reintegro->alumno->nombre_completo ?? 'Alumno no disponible',
                'monto' => '$' . number_format($reintegro->monto_solicitado, 0),
                'fecha' => $reintegro->fecha_solicitud->format('Y-m-d'),
                'tipo' => $reintegro->tipoGasto->nombre_tipo ?? $reintegro->descripcion_gasto ?? 'Tipo no especificado'
            ];
        })->toArray();
    }
    
    private function formatearTiempo($fecha)
    {
        if (!$fecha) return 'Fecha no disponible';
        
        $carbon = Carbon::parse($fecha);
        $ahora = Carbon::now();
        
        $diferencia = $ahora->diffInMinutes($carbon);
        
        if ($diferencia < 60) {
            return "Hace {$diferencia} minutos";
        } elseif ($diferencia < 1440) { // menos de 24 horas
            $horas = floor($diferencia / 60);
            return "Hace {$horas} " . ($horas == 1 ? 'hora' : 'horas');
        } elseif ($diferencia < 10080) { // menos de 7 días
            $dias = floor($diferencia / 1440);
            return "Hace {$dias} " . ($dias == 1 ? 'día' : 'días');
        } else {
            return $carbon->format('d/m/Y');
        }
    }
    
    private function loadUrgentes()
    {
        // Los casos urgentes se quitaron del sistema
        $this->urgentes = [];
    }
    
    public function render()
    {
        return view('livewire.dashboards.medico-dashboard');
    }
}