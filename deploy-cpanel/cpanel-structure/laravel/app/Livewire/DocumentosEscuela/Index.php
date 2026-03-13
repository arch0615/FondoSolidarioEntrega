<?php

namespace App\Livewire\DocumentosEscuela;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DocumentoInstitucional;
use App\Models\CatTipoDocumento;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $filtro_nombre = '';
    public $filtro_fecha_desde;
    public $filtro_fecha_hasta;
    public $filtro_escuela = '';

    // Propiedades para modal de escuelas
    public $mostrarModal = false;
    public $escuelasModal = [];

    public $sortField = 'nombre_documento';
    public $sortDirection = 'asc';
    public $perPage = 10;

    protected $queryString = [
        'filtro_nombre' => ['except' => ''],
        'filtro_fecha_desde' => ['except' => ''],
        'filtro_fecha_hasta' => ['except' => ''],
        'filtro_escuela' => ['except' => ''],
        'sortField' => ['except' => 'nombre_documento'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function render()
    {
        $documentos = $this->getDocumentos();
        $tipos_documento = CatTipoDocumento::orderBy('nombre_tipo_documento')->get();
        $escuelas = \App\Models\Escuela::where('activo', 1)->orderBy('nombre')->get();

        // Determinar si el usuario es administrador
        $isAdmin = Auth::user()->id_rol == 2;

        return view('livewire.documentos-escuela.index', compact('documentos', 'tipos_documento', 'escuelas', 'isAdmin'));
    }

    public function getDocumentos()
    {
        $query = DocumentoInstitucional::query()
            ->with(['tipoDocumento', 'escuela']);

        $user = Auth::user();

        // Si es administrador, mostrar documentos de todas las escuelas (excluindo nulos) y aplicar filtro de escuela si existe
        if ($user->id_rol == 2) { // Administrador
            // Excluir documentos donde id_escuela sea null
            $query->whereNotNull('id_escuela')
                  ->when($this->filtro_escuela, function ($query) {
                      $query->where('id_escuela', $this->filtro_escuela);
                  });
        } else {
            // Para usuarios no administradores, solo mostrar documentos de su escuela
            $query->where('id_escuela', $user->id_escuela);
        }

        $query->when($this->filtro_nombre, function ($query) {
                $query->where('nombre_documento', 'like', '%' . $this->filtro_nombre . '%');
            })
            ->when($this->filtro_fecha_desde, function ($query) {
                $query->whereDate('fecha_carga', '>=', $this->filtro_fecha_desde);
            })
            ->when($this->filtro_fecha_hasta, function ($query) {
                $query->whereDate('fecha_carga', '<=', $this->filtro_fecha_hasta);
            });

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
        $this->reset(['filtro_nombre', 'filtro_fecha_desde', 'filtro_fecha_hasta', 'filtro_escuela']);
        $this->resetPage();
    }

    public function eliminar($documentoId)
    {
        $documento = DocumentoInstitucional::where('id_documento', $documentoId)
            ->where('id_escuela', Auth::user()->id_escuela)
            ->first();

        if ($documento) {
            $datosDocumento = $documento->toArray();
            $documento->delete();
            AuditoriaService::registrarEliminacion('documentos_institucionales', $documentoId, $datosDocumento);
            session()->flash('message', 'Documento eliminado exitosamente.');
        }
    }

    public function updatingFiltroNombre() { $this->resetPage(); }
    public function updatingFiltroFechaDesde() { $this->resetPage(); }
    public function updatingFiltroFechaHasta() { $this->resetPage(); }
    public function updatingFiltroEscuela() { $this->resetPage(); }

    public function mostrarEscuelasModal($documentoId)
    {
        $user = Auth::user();

        // Para usuarios no administradores, mantener la restricción a su escuela
        $query = DocumentoInstitucional::with('escuela')->where('id_documento', $documentoId);

        if ($user->id_rol != 2) { // No administrador
            $query->where('id_escuela', $user->id_escuela);
        }

        $documento = $query->first();

        if ($documento && $documento->escuela) {
            $this->escuelasModal = collect([$documento->escuela]);
        } else {
            $this->escuelasModal = collect([]);
        }
        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->escuelasModal = [];
    }
}
