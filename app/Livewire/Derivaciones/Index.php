<?php

namespace App\Livewire\Derivaciones;

use App\Models\Derivacion;
use App\Models\Escuela;
use App\Models\Prestador;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Filtros
    public $filtro_accidente = '';
    public $filtro_prestador = '';
    public $filtro_fecha_derivacion = '';
    public $filtro_escuela = '';
    public $filtro_impresa = '';

    // Ordenamiento
    public $sortField = 'id_derivacion';
    public $sortDirection = 'desc';

    // Paginación
    public $perPage = 10;

    // Query String
    protected $queryString = [
        'filtro_accidente' => ['except' => ''],
        'filtro_prestador' => ['except' => ''],
        'filtro_fecha_derivacion' => ['except' => ''],
        'filtro_escuela' => ['except' => ''],
        'filtro_impresa' => ['except' => ''],
        'sortField' => ['except' => 'id_derivacion'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    public function render()
    {
        $derivaciones = $this->getDerivaciones();
        $prestadores = Prestador::where('activo', 1)->orderBy('nombre')->get();
        $escuelas = Escuela::where('activo', 1)->orderBy('nombre')->get();

        return view('livewire.derivaciones.index', compact('derivaciones', 'prestadores', 'escuelas'));
    }

    public function getDerivaciones()
    {
        $query = Derivacion::query()
            ->with(['accidente.escuela', 'prestador', 'alumno']);

        $usuario = Auth::user();

        // Filtrar por escuela según el rol del usuario
        if ($usuario->id_rol == 1 && $usuario->id_escuela) {
            // Usuario general: solo ve derivaciones de su escuela
            $query->whereHas('accidente', function ($q) use ($usuario) {
                $q->where('id_escuela', $usuario->id_escuela);
            });
        } elseif (in_array($usuario->id_rol, [2, 3]) && $this->filtro_escuela) {
            // Admin/Médico: filtra si se selecciona una escuela en el filtro
            $query->whereHas('accidente', function ($q) {
                $q->where('id_escuela', $this->filtro_escuela);
            });
        }

        $query->when($this->filtro_accidente, function ($query) {
                $query->where('id_accidente', 'like', '%' . $this->filtro_accidente . '%');
            })
            ->when($this->filtro_prestador, function ($query) {
                $query->where('id_prestador', $this->filtro_prestador);
            })
            ->when($this->filtro_fecha_derivacion, function ($query) {
                $query->where('fecha_derivacion', $this->filtro_fecha_derivacion);
            })
            ->when($this->filtro_impresa !== '', function ($query) {
                $impresa = $this->filtro_impresa === 'si';
                $query->where('impresa', $impresa);
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
        $this->reset(['filtro_accidente', 'filtro_prestador', 'filtro_fecha_derivacion', 'filtro_escuela', 'filtro_impresa']);
        $this->resetPage();
    }
    
    public function imprimir($derivacionId)
    {
        $derivacion = Derivacion::findOrFail($derivacionId);
        $derivacion->impresa = true;
        $derivacion->fecha_impresion = now();
        $derivacion->save();

        AuditoriaService::registrarActualizacion(
            'derivaciones',
            $derivacion->id_derivacion,
            ['impresa' => false],
            ['impresa' => true]
        );

        session()->flash('message', 'Derivación marcada como impresa. Puede proceder a imprimir.');
        
        // Lógica para abrir la vista de impresión en una nueva pestaña
        $this->dispatch('imprimir-derivacion', id: $derivacionId);
    }

    // Reseteo de página al actualizar filtros
    public function updatingFiltroAccidente() { $this->resetPage(); }
    public function updatingFiltroPrestador() { $this->resetPage(); }
    public function updatingFiltroFechaDerivacion() { $this->resetPage(); }
    public function updatingFiltroEscuela() { $this->resetPage(); }
    public function updatingFiltroImpresa() { $this->resetPage(); }
}
