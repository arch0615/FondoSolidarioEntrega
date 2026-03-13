<?php

namespace App\Livewire\Empleados;

use App\Models\Escuela;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Empleado;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $filtro_nombre = '';
    public $filtro_apellido = '';
    public $filtro_dni = '';
    public $filtro_escuela = '';
    public $filtro_estado = '';

    public $sortField = 'apellido';
    public $sortDirection = 'asc';

    public $perPage = 10;

    protected $queryString = [
        'filtro_nombre' => ['except' => ''],
        'filtro_apellido' => ['except' => ''],
        'filtro_dni' => ['except' => ''],
        'filtro_escuela' => ['except' => ''],
        'filtro_estado' => ['except' => ''],
        'sortField' => ['except' => 'apellido'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function render()
    {
        $empleados = $this->getEmpleados();
        $escuelas = Escuela::orderBy('nombre')->get();

        return view('livewire.empleados.index', compact('empleados', 'escuelas'));
    }

    public function getEmpleados()
    {
        $query = Empleado::query()->with('escuela');

        $usuario = Auth::user();

        if ($usuario && $usuario->id_rol == 1) {
            $query->where('id_escuela', $usuario->id_escuela);
        } else {
            $query->when($this->filtro_escuela, function ($query) {
                $query->where('id_escuela', $this->filtro_escuela);
            });
        }

        $query->when($this->filtro_nombre, function ($query) {
                $query->where('nombre', 'like', '%' . $this->filtro_nombre . '%');
            })
            ->when($this->filtro_apellido, function ($query) {
                $query->where('apellido', 'like', '%' . $this->filtro_apellido . '%');
            })
            ->when($this->filtro_dni, function ($query) {
                $query->where('dni', 'like', '%' . $this->filtro_dni . '%');
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
        $this->reset(['filtro_nombre', 'filtro_apellido', 'filtro_dni', 'filtro_escuela', 'filtro_estado']);
        $this->resetPage();
    }

    public function cambiarEstado($empleadoId)
    {
        $empleado = Empleado::findOrFail($empleadoId);
        $estadoAnterior = $empleado->activo;
        
        $empleado->activo = !$empleado->activo;
        $empleado->save();

        AuditoriaService::registrarActualizacion(
            'empleados',
            $empleado->id_empleado,
            ['activo' => $estadoAnterior],
            ['activo' => $empleado->activo]
        );

        $estado = $empleado->activo ? 'activado' : 'desactivado';
        session()->flash('message', "Empleado {$estado} exitosamente.");
    }

    public function eliminar($empleadoId)
    {
        $empleado = Empleado::findOrFail($empleadoId);
        $datosEmpleado = $empleado->toArray();
        $empleado->delete();

        AuditoriaService::registrarEliminacion('empleados', $empleadoId, $datosEmpleado);
        session()->flash('message', 'Empleado eliminado exitosamente.');
    }

    public function updatingFiltroNombre() { $this->resetPage(); }
    public function updatingFiltroApellido() { $this->resetPage(); }
    public function updatingFiltroDni() { $this->resetPage(); }
    public function updatingFiltroEscuela() { $this->resetPage(); }
    public function updatingFiltroEstado() { $this->resetPage(); }

    public function imprimirBeneficiarios($empleadoId)
    {
        // Lógica para abrir la vista de impresión de beneficiarios SVO en una nueva pestaña
        $this->dispatch('imprimir-beneficiarios', id: $empleadoId);
    }
}
