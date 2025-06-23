<?php

namespace App\Livewire\Alumnos;

use App\Models\Alumno;
use App\Models\Escuela;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    // Filtros
    public $filtro_nombre = '';
    public $filtro_apellido = '';
    public $filtro_dni = '';
    public $filtro_grado = '';
    public $filtro_escuela = '';
    public $filtro_estado = '';

    // Ordenamiento
    public $sortField = 'apellido';
    public $sortDirection = 'asc';

    // Paginación
    public $perPage = 10;

    // Query String
    protected $queryString = [
        'filtro_nombre' => ['except' => ''],
        'filtro_apellido' => ['except' => ''],
        'filtro_dni' => ['except' => ''],
        'filtro_grado' => ['except' => ''],
        'filtro_escuela' => ['except' => ''],
        'filtro_estado' => ['except' => ''],
        'sortField' => ['except' => 'apellido'],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 10],
    ];

    public function render()
    {
        $alumnos = $this->getAlumnos();
        $escuelas = Escuela::where('activo', true)->orderBy('nombre')->get();

        return view('livewire.alumnos.index', compact('alumnos', 'escuelas'));
    }

    public function getAlumnos()
    {
        $query = Alumno::query()->with('escuela');

        // Filtrar por rol de usuario
        $user = Auth::user();
        if ($user->id_rol == 1 && $user->id_escuela) {
            $query->where('id_escuela', $user->id_escuela);
        }

        $query->when($this->filtro_nombre, fn ($q) => $q->where('nombre', 'like', '%' . $this->filtro_nombre . '%'))
            ->when($this->filtro_apellido, fn ($q) => $q->where('apellido', 'like', '%' . $this->filtro_apellido . '%'))
            ->when($this->filtro_dni, fn ($q) => $q->where('dni', 'like', '%' . $this->filtro_dni . '%'))
            ->when($this->filtro_grado, fn ($q) => $q->where('sala_grado_curso', 'like', '%' . $this->filtro_grado . '%'))
            ->when($this->filtro_escuela && $user->id_rol != 1, fn ($q) => $q->where('id_escuela', $this->filtro_escuela))
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
        $this->reset(['filtro_nombre', 'filtro_apellido', 'filtro_dni', 'filtro_grado', 'filtro_escuela', 'filtro_estado']);
        $this->resetPage();
    }

    public function cambiarEstado($alumnoId)
    {
        $alumno = Alumno::findOrFail($alumnoId);
        $estadoAnterior = $alumno->activo;
        
        $alumno->activo = !$alumno->activo;
        $alumno->save();

        // Auditoría
        $auditoriaService = new AuditoriaService();
        $auditoriaService->registrarActualizacion(
            'alumnos',
            $alumno->id_alumno,
            ['activo' => $estadoAnterior],
            ['activo' => $alumno->activo]
        );

        $estado = $alumno->activo ? 'activado' : 'desactivado';
        session()->flash('message', "Alumno {$estado} exitosamente.");
    }

    // Métodos para resetear página en filtros
    public function updatingFiltroNombre() { $this->resetPage(); }
    public function updatingFiltroApellido() { $this->resetPage(); }
    public function updatingFiltroDni() { $this->resetPage(); }
    public function updatingFiltroGrado() { $this->resetPage(); }
    public function updatingFiltroEscuela() { $this->resetPage(); }
    public function updatingFiltroEstado() { $this->resetPage(); }
}
