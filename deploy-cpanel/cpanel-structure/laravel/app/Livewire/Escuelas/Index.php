<?php

namespace App\Livewire\Escuelas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Escuela;
use App\Services\AuditoriaService;

class Index extends Component
{
    use WithPagination;

    // Filtros
    public $filtro_nombre = '';
    public $filtro_codigo = '';
    public $filtro_estado = '';

    // Ordenamiento
    public $sortField = 'nombre';
    public $sortDirection = 'asc';

    // Paginación
    public $perPage = 10;

    // Query String para mantener filtros en URL
    protected $queryString = [
        'filtro_nombre' => ['except' => ''],
        'filtro_codigo' => ['except' => ''],
        'filtro_estado' => ['except' => ''],
        'sortField' => ['except' => 'nombre'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function render()
    {
        $escuelas = $this->getEscuelas();
        
        return view('livewire.escuelas.index', compact('escuelas'));
    }

    public function getEscuelas()
    {
        $query = Escuela::query()
            ->withCount([
                'alumnos',
                'empleados',
                'accidentes',
                'salidasEducativas',
                'pasantias',
                'beneficiariosSvo'
            ])
            ->when($this->filtro_nombre, function ($query) {
                $query->where('nombre', 'like', '%' . $this->filtro_nombre . '%');
            })
            ->when($this->filtro_codigo, function ($query) {
                $query->where('codigo_escuela', 'like', '%' . $this->filtro_codigo . '%');
            })
            ->when($this->filtro_estado !== '', function ($query) {
                $activo = $this->filtro_estado === 'activo';
                $query->where('activo', $activo);
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
        $this->reset(['filtro_nombre', 'filtro_codigo', 'filtro_estado']);
        $this->resetPage();
    }

    public function cambiarEstado($escuelaId)
    {
        $escuela = Escuela::findOrFail($escuelaId);
        $estadoAnterior = $escuela->activo;
        
        $escuela->activo = !$escuela->activo;
        $escuela->save();

        AuditoriaService::registrarActualizacion(
            'escuelas',
            $escuelaId,
            ['activo' => $estadoAnterior],
            ['activo' => $escuela->activo]
        );

        $estado = $escuela->activo ? 'activada' : 'desactivada';
        session()->flash('message', "Escuela {$estado} exitosamente.");
    }

    public function eliminar($escuelaId)
    {
        $escuela = Escuela::findOrFail($escuelaId);
        $datosEscuela = $escuela->toArray();
        $escuela->delete();

        AuditoriaService::registrarEliminacion('escuelas', $escuelaId, $datosEscuela);
        session()->flash('message', 'Escuela eliminada exitosamente.');
    }

    public function updatingFiltroNombre() { $this->resetPage(); }
    public function updatingFiltroCodigo() { $this->resetPage(); }
    public function updatingFiltroEstado() { $this->resetPage(); }
}
