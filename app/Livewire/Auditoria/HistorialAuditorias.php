<?php

namespace App\Livewire\Auditoria;

use App\Models\AuditoriaSistema;
use App\Models\Escuela;
use App\Models\SolicitudInfoAuditor;
use Livewire\Component;
use Livewire\WithPagination;

class HistorialAuditorias extends Component
{
    use WithPagination;

    public $filtro_fecha_desde = '';
    public $filtro_fecha_hasta = '';
    public $filtro_escuela = '';
    public $sortField = 'fecha_hora';
    public $sortDirection = 'desc';
    public $perPage = 10;

    protected $queryString = [
        'filtro_fecha_desde' => ['except' => ''],
        'filtro_fecha_hasta' => ['except' => ''],
        'filtro_escuela' => ['except' => ''],
        'sortField' => ['except' => 'fecha_hora'],
        'sortDirection' => ['except' => 'desc'],
        'page' => ['except' => 1],
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->reset(['filtro_fecha_desde', 'filtro_fecha_hasta', 'filtro_escuela']);
        $this->resetPage();
    }

    public function render()
    {
        // 1. Obtener solicitudes de información
        $solicitudesQuery = SolicitudInfoAuditor::query()
            ->with(['reintegro.accidente.alumnos.alumno', 'reintegro.accidente.escuela', 'auditor', 'estadoSolicitud']);

        // Aplicar filtros comunes
        if ($this->filtro_fecha_desde) {
            $solicitudesQuery->where('fecha_solicitud', '>=', $this->filtro_fecha_desde);
        }
        if ($this->filtro_fecha_hasta) {
            $solicitudesQuery->where('fecha_solicitud', '<=', $this->filtro_fecha_hasta);
        }
        if ($this->filtro_escuela) {
            $solicitudesQuery->whereHas('reintegro.accidente', function ($q) {
                $q->where('id_escuela', $this->filtro_escuela);
            });
        }
        
        // Aplicar ordenamiento y paginación
        $solicitudes = $solicitudesQuery->orderBy('fecha_solicitud', $this->sortDirection)->paginate($this->perPage);

        $escuelas = Escuela::where('activo', 1)->orderBy('nombre')->get();

        return view('livewire.auditoria.historial-auditorias', [
            'solicitudes' => $solicitudes,
            'escuelas' => $escuelas,
        ]);
    }
}