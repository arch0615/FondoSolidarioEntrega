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

        // Si se intenta desactivar, verificar si tiene cuenta de usuario en el sistema
        if ($empleado->activo && \App\Models\User::where('email', $empleado->email)->exists()) {
            $this->dispatch('toast', message: 'No se puede desactivar el empleado porque tiene una cuenta de usuario en el sistema. Debe darse de baja primero desde la gestión de usuarios.', type: 'error');
            return;
        }

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

        // Check for linked beneficiarios_svo or fallecimientos
        if (\App\Models\BeneficiarioSvo::where('id_empleado', $empleadoId)->exists()) {
            $this->dispatch('toast', message: 'No se puede eliminar el empleado porque tiene beneficiarios SVO asociados. Puede desactivarlo en su lugar.', type: 'error');
            return;
        }

        if (\Illuminate\Support\Facades\DB::table('fallecimientos')->where('id_empleado', $empleadoId)->exists()) {
            $this->dispatch('toast', message: 'No se puede eliminar el empleado porque tiene registros de fallecimiento asociados. Puede desactivarlo en su lugar.', type: 'error');
            return;
        }

        // Check if employee has a linked system user account
        if (\App\Models\User::where('email', $empleado->email)->exists()) {
            $this->dispatch('toast', message: 'No se puede eliminar el empleado porque tiene una cuenta de usuario en el sistema. Desactívelo en su lugar.', type: 'error');
            return;
        }

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
