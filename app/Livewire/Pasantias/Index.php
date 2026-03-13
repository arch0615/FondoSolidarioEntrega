<?php

namespace App\Livewire\Pasantias;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pasantia;
use App\Models\Escuela;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    // 🔥 FILTROS: Según los campos del prototipo
    public $filtro_empresa = '';
    public $filtro_alumno = '';
    public $filtro_escuela = '';
    public $filtro_fecha_inicio = '';

    // 🔥 ORDENAMIENTO
    public $sortField = 'fecha_inicio';
    public $sortDirection = 'desc';

    // 🔥 PAGINACIÓN
    public $perPage = 10;

    // 🔥 QUERY STRING para mantener filtros en URL
    protected $queryString = [
        'filtro_empresa' => ['except' => ''],
        'filtro_alumno' => ['except' => ''],
        'filtro_escuela' => ['except' => ''],
        'filtro_fecha_inicio' => ['except' => ''],
        'sortField' => ['except' => 'fecha_inicio'],
        'sortDirection' => ['except' => 'desc'],
    ];

    // 🔥 MÉTODO RENDER: Conectar con BD
    public function render()
    {
        $pasantias = $this->getPasantias();
        $escuelas = Escuela::orderBy('nombre')->get();
        
        // Registrar consulta en auditoría
        /* AuditoriaService::registrarConsulta('pasantias', [
            'filtro_empresa' => $this->filtro_empresa,
            'filtro_alumno' => $this->filtro_alumno,
            'filtro_escuela' => $this->filtro_escuela,
            'filtro_fecha_inicio' => $this->filtro_fecha_inicio,
        ]); */
        
        return view('livewire.pasantias.index', compact('pasantias', 'escuelas'));
    }

    // 🔥 MÉTODO PRINCIPAL: Consulta a BD con filtros
    public function getPasantias()
    {
        $query = Pasantia::query()
            ->with(['escuela', 'alumno', 'usuarioCarga'])
            ->when($this->filtro_empresa, function ($query) {
                $query->where('empresa', 'like', '%' . $this->filtro_empresa . '%');
            })
            ->when($this->filtro_alumno, function ($query) {
                $query->whereHas('alumno', function ($subQuery) {
                    $subQuery->where('nombre', 'like', '%' . $this->filtro_alumno . '%')
                            ->orWhere('apellido', 'like', '%' . $this->filtro_alumno . '%');
                });
            })
            ->when($this->filtro_fecha_inicio, function ($query) {
                $query->whereDate('fecha_inicio', '>=', $this->filtro_fecha_inicio);
            });

        // Aplicar filtro por escuela del usuario si es usuario general (rol = 1)
        $usuario = Auth::user();
        if ($usuario && $usuario->id_rol == 1 && $usuario->id_escuela) {
            $query->where('id_escuela', $usuario->id_escuela);
        } else {
            // Si es admin u otro rol, aplicar el filtro de la vista solo si se seleccionó
            $query->when($this->filtro_escuela, function ($query) {
                $query->where('id_escuela', $this->filtro_escuela);
            });
        }

        // Aplicar ordenamiento
        if ($this->sortField === 'alumno') {
            $query->join('alumnos', 'pasantias.id_alumno', '=', 'alumnos.id_alumno')
                  ->orderBy('alumnos.apellido', $this->sortDirection)
                  ->orderBy('alumnos.nombre', $this->sortDirection)
                  ->select('pasantias.*');
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        return $query->paginate($this->perPage);
    }

    // 🔥 MÉTODOS DE ACCIÓN
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
        $this->reset(['filtro_empresa', 'filtro_alumno', 'filtro_escuela', 'filtro_fecha_inicio']);
        $this->resetPage();
    }

    public function eliminar($pasantiaId)
    {
        $pasantia = Pasantia::findOrFail($pasantiaId);
        $datosPasantia = $pasantia->toArray();
        $pasantia->delete();

        AuditoriaService::registrarEliminacion('pasantias', $pasantiaId, $datosPasantia);
        session()->flash('message', 'Pasantía eliminada exitosamente.');
    }

    // 🔥 MÉTODOS PARA RESETEAR PÁGINA EN FILTROS
    public function updatingFiltroEmpresa() { $this->resetPage(); }
    public function updatingFiltroAlumno() { $this->resetPage(); }
    public function updatingFiltroEscuela() { $this->resetPage(); }
    public function updatingFiltroFechaInicio() { $this->resetPage(); }
}