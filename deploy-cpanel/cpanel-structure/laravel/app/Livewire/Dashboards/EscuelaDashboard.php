<?php

namespace App\Livewire\Dashboards;

use App\Models\Accidente;
use App\Models\Alumno;
use App\Models\ArchivoAdjunto;
use App\Models\Derivacion;
use App\Models\DocumentoInstitucional;
use App\Models\Reintegro;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EscuelaDashboard extends Component
{
    public $stats = [];
    public $recentActivity = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadRecentActivity();
    }

    private function loadStats()
    {
        $user = Auth::user();
        if (!$user || !$user->id_escuela) {
            $this->stats = $this->getEmptyStats();
            return;
        }

        $idEscuela = $user->id_escuela;
        $now = Carbon::now();

        // Accidentes
        $accidentesQuery = Accidente::where('id_escuela', $idEscuela);
        $totalAccidentes = (clone $accidentesQuery)->count();
        $accidentesEsteMes = (clone $accidentesQuery)->whereYear('fecha_accidente', $now->year)->whereMonth('fecha_accidente', $now->month)->count();

        // Alumnos
        $totalAlumnos = Alumno::where('id_escuela', $idEscuela)->where('activo', true)->count();

        // Reintegros Pendientes (Estados: 1-Solicitado, 2-En Auditoria, 3-Requiere Mas Info)
        $reintegrosPendientes = Reintegro::whereIn('id_estado_reintegro', [1, 2, 3])
            ->whereHas('accidente', fn($q) => $q->where('id_escuela', $idEscuela))
            ->count();

        // Documentos Institucionales
        $documentosQuery = DocumentoInstitucional::where('id_escuela', $idEscuela);
        $totalDocumentos = (clone $documentosQuery)->count();
        $documentosEstaSemana = (clone $documentosQuery)->whereBetween('fecha_carga', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        $this->stats = [
            'accidentes_reportados' => ['total' => $totalAccidentes, 'incremento' => "↑ $accidentesEsteMes este mes", 'color' => 'red'],
            'alumnos_registrados' => ['total' => $totalAlumnos, 'incremento' => 'Activos', 'color' => 'primary'],
            'reintegros_pendientes' => ['total' => $reintegrosPendientes, 'incremento' => 'En proceso', 'color' => 'amber'],
            'documentos_subidos' => ['total' => $totalDocumentos, 'incremento' => "↑ $documentosEstaSemana esta semana", 'color' => 'primary'],
        ];
    }

    private function loadRecentActivity()
    {
        $user = Auth::user();
        if (!$user || !$user->id_escuela) {
            $this->recentActivity = [];
            return;
        }
        
        $idEscuela = $user->id_escuela;
        $activity = [];

        // Último accidente
        $lastAccident = Accidente::with('alumnos.alumno')->where('id_escuela', $idEscuela)->latest('fecha_carga')->first();
        if ($lastAccident) {
            $activity[] = [
                'tipo' => 'accidente',
                'titulo' => 'Último accidente reportado',
                'descripcion' => $lastAccident->nombres_alumnos ?: 'Sin alumnos asignados',
                'date' => Carbon::parse($lastAccident->fecha_carga),
                'icono' => 'fas fa-shield-alt',
                'color' => 'red'
            ];
        }

        // Último reintegro solicitado
        $lastReintegro = Reintegro::with('alumno')->whereHas('accidente', fn($q) => $q->where('id_escuela', $idEscuela))->latest('fecha_solicitud')->first();
        if ($lastReintegro) {
            $activity[] = [
                'tipo' => 'reintegro',
                'titulo' => 'Reintegro solicitado',
                'descripcion' => ($lastReintegro->alumno->nombre_completo ?? 'N/A') . ' - $' . number_format($lastReintegro->monto_solicitado, 2),
                'date' => Carbon::parse($lastReintegro->fecha_solicitud),
                'icono' => 'fas fa-hand-holding-usd',
                'color' => 'primary'
            ];
        }

        // Última derivación
        $lastDerivacion = Derivacion::with('accidente.alumnos.alumno')->whereHas('accidente', fn($q) => $q->where('id_escuela', $idEscuela))->latest('fecha_derivacion')->first();
        if ($lastDerivacion) {
            $activity[] = [
                'tipo' => 'derivacion',
                'titulo' => 'Derivación generada',
                'descripcion' => $lastDerivacion->accidente->nombres_alumnos ?: 'Sin alumnos asignados',
                'date' => Carbon::parse($lastDerivacion->fecha_derivacion),
                'icono' => 'fas fa-file-medical',
                'color' => 'primary'
            ];
        }

        // Ordenar por fecha real y luego formatear el tiempo
        $this->recentActivity = collect($activity)->sortByDesc('date')->map(function ($item) {
            $item['tiempo'] = $item['date']->diffForHumans();
            unset($item['date']);
            return $item;
        })->values()->all();
    }

    private function getEmptyStats()
    {
        return [
            'accidentes_reportados' => ['total' => 0, 'incremento' => 'N/A', 'color' => 'red'],
            'alumnos_registrados' => ['total' => 0, 'incremento' => 'N/A', 'color' => 'primary'],
            'reintegros_pendientes' => ['total' => 0, 'incremento' => 'N/A', 'color' => 'amber'],
            'documentos_subidos' => ['total' => 0, 'incremento' => 'N/A', 'color' => 'primary'],
        ];
    }

    public function render()
    {
        return view('livewire.dashboards.escuela-dashboard');
    }
}