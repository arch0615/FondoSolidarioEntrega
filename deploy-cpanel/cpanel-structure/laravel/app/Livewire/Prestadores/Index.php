<?php

namespace App\Livewire\Prestadores;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Prestador;
use App\Services\AuditoriaService;
use App\Models\CatTipoPrestador;

class Index extends Component
{
    use WithPagination;

    // Filtros
    public $filtro_nombre = '';
    public $filtro_tipo = '';
    public $filtro_especialidad = '';
    public $filtro_estado = '';

    // Ordenamiento
    public $sortField = 'nombre';
    public $sortDirection = 'asc';

    // Paginación
    public $perPage = 10;

    // Query String
    protected $queryString = [
        'filtro_nombre' => ['except' => ''],
        'filtro_tipo' => ['except' => ''],
        'filtro_especialidad' => ['except' => ''],
        'filtro_estado' => ['except' => ''],
        'sortField' => ['except' => 'nombre'],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 10],
    ];

    public function render()
    {
        $prestadores = $this->getPrestadores();
        $tiposPrestador = CatTipoPrestador::orderBy('descripcion')->get();
        
        return view('livewire.prestadores.index', compact('prestadores', 'tiposPrestador'));
    }

    public function getPrestadores()
    {
        $query = Prestador::query()
            ->with('tipoPrestador')
            ->when($this->filtro_nombre, function ($query) {
                $query->where('nombre', 'like', '%' . $this->filtro_nombre . '%');
            })
            ->when($this->filtro_tipo, function ($query) {
                $query->where('id_tipo_prestador', $this->filtro_tipo);
            })
            ->when($this->filtro_especialidad, function ($query) {
                $query->where('especialidades', 'like', '%' . $this->filtro_especialidad . '%');
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
        $this->reset(['filtro_nombre', 'filtro_tipo', 'filtro_especialidad', 'filtro_estado']);
        $this->resetPage();
    }

    public function cambiarEstado($prestadorId)
    {
        $prestador = Prestador::findOrFail($prestadorId);
        $estadoAnterior = $prestador->activo;
        
        $prestador->activo = !$prestador->activo;
        $prestador->save();

        AuditoriaService::registrarActualizacion(
            'prestadores',
            $prestadorId,
            ['activo' => $estadoAnterior],
            ['activo' => $prestador->activo]
        );

        $estado = $prestador->activo ? 'activado' : 'desactivado';
        session()->flash('message', "Prestador {$estado} exitosamente.");
    }

    public function eliminar($prestadorId)
    {
        $prestador = Prestador::findOrFail($prestadorId);
        $datosPrestador = $prestador->toArray();
        $prestador->delete();

        AuditoriaService::registrarEliminacion('prestadores', $prestadorId, $datosPrestador);
        session()->flash('message', 'Prestador eliminado exitosamente.');
    }

    public function updatingFiltroNombre() { $this->resetPage(); }
    public function updatingFiltroTipo() { $this->resetPage(); }
    public function updatingFiltroEspecialidad() { $this->resetPage(); }
    public function updatingFiltroEstado() { $this->resetPage(); }
}
