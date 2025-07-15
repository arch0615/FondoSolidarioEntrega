<?php

namespace App\Livewire\Documentos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DocumentoInstitucional;
use App\Models\CatTipoDocumento;
use App\Services\AuditoriaService;

class Index extends Component
{
    use WithPagination;

    public $filtro_nombre = '';
    public $filtro_tipo_documento = '';
    public $filtro_fecha_desde;
    public $filtro_fecha_hasta;
    public $filtro_escuela = '';

    public $sortField = 'nombre_documento';
    public $sortDirection = 'asc';
    public $perPage = 10;

    protected $queryString = [
        'filtro_nombre' => ['except' => ''],
        'filtro_tipo_documento' => ['except' => ''],
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
        
        return view('livewire.documentos.index', compact('documentos', 'tipos_documento', 'escuelas'));
    }

    public function getDocumentos()
    {
        $query = DocumentoInstitucional::query()
            ->with(['escuela', 'tipoDocumento', 'usuarioCarga']);

        $user = auth()->user();

        if ($user->id_rol == 1) {
            $query->where('id_escuela', $user->id_escuela);
        } else {
            $query->when($this->filtro_escuela, function ($query) {
                $query->where('id_escuela', $this->filtro_escuela);
            });
        }

        $query->when($this->filtro_nombre, function ($query) {
                $query->where('nombre_documento', 'like', '%' . $this->filtro_nombre . '%');
            })
            ->when($this->filtro_tipo_documento, function ($query) {
                $query->where('id_tipo_documento', $this->filtro_tipo_documento);
            })
            ->when($this->filtro_fecha_desde, function ($query) {
                $query->whereDate('fecha_vencimiento', '>=', $this->filtro_fecha_desde);
            })
            ->when($this->filtro_fecha_hasta, function ($query) {
                $query->whereDate('fecha_vencimiento', '<=', $this->filtro_fecha_hasta);
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
        $this->reset(['filtro_nombre', 'filtro_tipo_documento', 'filtro_fecha_desde', 'filtro_fecha_hasta', 'filtro_escuela']);
        $this->resetPage();
    }

    public function eliminar($documentoId)
    {
        $documento = DocumentoInstitucional::findOrFail($documentoId);
        $datosDocumento = $documento->toArray();
        
        $documento->delete();

        AuditoriaService::registrarEliminacion('documentos_institucionales', $documentoId, $datosDocumento);
        session()->flash('message', 'Documento eliminado exitosamente.');
    }

    public function updatingFiltroNombre() { $this->resetPage(); }
    public function updatingFiltroTipoDocumento() { $this->resetPage(); }
    public function updatingFiltroFechaDesde() { $this->resetPage(); }
    public function updatingFiltroFechaHasta() { $this->resetPage(); }
    public function updatingFiltroEscuela() { $this->resetPage(); }
}
