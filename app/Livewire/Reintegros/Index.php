<?php

namespace App\Livewire\Reintegros;

use App\Models\CatEstadoReintegro;
use App\Models\Escuela;
use App\Models\Reintegro;
use App\Services\AuditoriaService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $showingObservationModal = false;
    public $observationToShow = '';
    public $estadoRechazadoId;
    public $estadoAutorizadoId;
    public $estadoPagadoId;
    public $showingPagoInfoModal = false;
    public $pagoInfoToShow;

    // Filtros
    public $filtro_id_accidente = '';
    public $filtro_escuela = '';
    public $filtro_fecha_solicitud = '';
    public $filtro_estado = '';

    // Catálogos para filtros
    public $escuelas;
    public $estados;

    // Ordenamiento
    public $sortField = 'id_reintegro';
    public $sortDirection = 'desc';

    // Paginación
    public $perPage = 10;

    // Query String
    protected $queryString = [
        'filtro_id_accidente' => ['except' => ''],
        'filtro_escuela' => ['except' => ''],
        'filtro_fecha_solicitud' => ['except' => ''],
        'filtro_estado' => ['except' => ''],
        'sortField' => ['except' => 'id_reintegro'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    public function mount()
    {
        $this->escuelas = Escuela::orderBy('nombre')->get();
        $this->estados = CatEstadoReintegro::orderBy('descripcion')->get();
        $this->estadoRechazadoId = CatEstadoReintegro::where('nombre_estado', 'Rechazado')->first()->id_estado_reintegro ?? 4;
        $this->estadoAutorizadoId = CatEstadoReintegro::where('nombre_estado', 'Autorizado')->first()->id_estado_reintegro ?? 3;
        $this->estadoPagadoId = CatEstadoReintegro::where('nombre_estado', 'Pagado')->first()->id_estado_reintegro ?? 5;
    }

    public function render()
    {
        $reintegros = $this->getReintegros();
        
        return view('livewire.reintegros.index', compact('reintegros'));
    }

    public function getReintegros()
    {
        $usuario = \Illuminate\Support\Facades\Auth::user();
        $query = Reintegro::query()
            ->with(['accidente', 'alumno', 'estadoReintegro'])
            ->when($this->filtro_id_accidente, function ($query) {
                $query->whereHas('accidente', function($q) {
                    $q->where('id_accidente_entero', 'like', '%' . $this->filtro_id_accidente . '%');
                });
            })
            ->when($this->filtro_escuela, function ($query) {
                $query->whereHas('accidente.escuela', function($q) {
                    $q->where('id_escuela', $this->filtro_escuela);
                });
            })
            ->when($this->filtro_fecha_solicitud, function ($query) {
                $query->where('fecha_solicitud', 'like', '%' . $this->filtro_fecha_solicitud . '%');
            })
            ->when($this->filtro_estado, function ($query) {
                $query->where('id_estado_reintegro', $this->filtro_estado);
            });

        // Filtrar por escuela para rol de usuario general
        if ($usuario && $usuario->id_rol == 1 && $usuario->id_escuela) {
            $query->whereHas('accidente', function ($q) use ($usuario) {
                $q->where('id_escuela', $usuario->id_escuela);
            });
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->reset(['filtro_id_accidente', 'filtro_escuela', 'filtro_fecha_solicitud', 'filtro_estado']);
        $this->resetPage();
    }

    public function eliminar($idReintegro)
    {
        $reintegro = Reintegro::findOrFail($idReintegro);
        $datosReintegro = $reintegro->toArray();
        
        // La lógica de eliminación de archivos adjuntos está en el boot() del modelo
        $reintegro->delete();

        AuditoriaService::registrarEliminacion('reintegros', $idReintegro, $datosReintegro);
        session()->flash('message', 'Reintegro eliminado exitosamente.');
    }

    public function showObservation($reintegroId)
    {
        $reintegro = Reintegro::findOrFail($reintegroId);
        $this->observationToShow = $reintegro->observaciones_auditor;
        $this->showingObservationModal = true;
    }

    public function closeObservationModal()
    {
        $this->showingObservationModal = false;
        $this->observationToShow = '';
    }

    public function showPagoInfo($reintegroId)
    {
        $this->pagoInfoToShow = Reintegro::findOrFail($reintegroId);
        $this->showingPagoInfoModal = true;
    }

    public function closePagoInfoModal()
    {
        $this->showingPagoInfoModal = false;
        $this->pagoInfoToShow = null;
    }

    // Hooks para resetear paginación
    public function updatingFiltroIdAccidente() { $this->resetPage(); }
    public function updatingFiltroEscuela() { $this->resetPage(); }
    public function updatingFiltroFechaSolicitud() { $this->resetPage(); }
    public function updatingFiltroEstado() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }
}