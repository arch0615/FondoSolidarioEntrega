<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Role;
use App\Models\Escuela;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    // Filtros
    public $filtro_nombre = '';
    public $filtro_apellido = '';
    public $filtro_email = '';
    public $filtro_rol = '';
    public $filtro_escuela = '';
    public $filtro_estado = '';
    public $filtro_verificado = '';

    // Ordenamiento
    public $sortField = 'nombre';
    public $sortDirection = 'asc';

    // Paginación
    public $perPage = 10;

    protected $queryString = [
        'filtro_nombre' => ['except' => ''],
        'filtro_apellido' => ['except' => ''],
        'filtro_email' => ['except' => ''],
        'filtro_rol' => ['except' => ''],
        'filtro_escuela' => ['except' => ''],
        'filtro_estado' => ['except' => ''],
        'filtro_verificado' => ['except' => ''],
        'sortField' => ['except' => 'nombre'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function mount()
    {
        // No necesitamos auditar consultas, solo modificaciones
    }

    public function render()
    {
        $usuarios = $this->getUsuarios();
        $roles = Role::where('activo', true)->get();
        $escuelas = Escuela::where('activo', true)->get();

        return view('livewire.usuarios.index', compact('usuarios', 'roles', 'escuelas'));
    }

    public function getUsuarios()
    {
        $query = User::with(['role', 'escuela'])
            ->when($this->filtro_nombre, function ($query) {
                $query->where('nombre', 'like', '%' . $this->filtro_nombre . '%');
            })
            ->when($this->filtro_apellido, function ($query) {
                $query->where('apellido', 'like', '%' . $this->filtro_apellido . '%');
            })
            ->when($this->filtro_email, function ($query) {
                $query->where('email', 'like', '%' . $this->filtro_email . '%');
            })
            ->when($this->filtro_rol, function ($query) {
                $query->where('id_rol', $this->filtro_rol);
            })
            ->when($this->filtro_escuela, function ($query) {
                $query->where('id_escuela', $this->filtro_escuela);
            })
            ->when($this->filtro_estado !== '', function ($query) {
                $activo = $this->filtro_estado === 'activo';
                $query->where('activo', $activo);
            })
            ->when($this->filtro_verificado !== '', function ($query) {
                $verificado = $this->filtro_verificado === '1';
                $query->where('email_verificado', $verificado);
            });

        // Aplicar ordenamiento
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

    public function buscar()
    {
        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->reset([
            'filtro_nombre',
            'filtro_apellido', 
            'filtro_email',
            'filtro_rol',
            'filtro_escuela',
            'filtro_estado',
            'filtro_verificado'
        ]);
        $this->resetPage();
    }

    public function cambiarEstado($usuarioId)
    {
        $usuario = User::findOrFail($usuarioId);
        $estadoAnterior = $usuario->activo;
        
        $usuario->activo = !$usuario->activo;
        $usuario->save();

        // Registrar en auditoría
        AuditoriaService::registrarActualizacion(
            'usuarios',
            $usuarioId,
            ['activo' => $estadoAnterior],
            ['activo' => $usuario->activo]
        );

        $estado = $usuario->activo ? 'activado' : 'desactivado';
        session()->flash('message', "Usuario {$estado} exitosamente.");
    }


    public function eliminar($usuarioId)
    {
        $usuario = User::findOrFail($usuarioId);
        
        // Verificar que no sea el usuario actual
        if ($usuario->id_usuario === Auth::id()) {
            session()->flash('error', 'No puedes eliminar tu propio usuario.');
            return;
        }

        $datosUsuario = $usuario->toArray();
        $usuario->delete();

        // Registrar en auditoría
        AuditoriaService::registrarEliminacion('usuarios', $usuarioId, $datosUsuario);

        session()->flash('message', 'Usuario eliminado exitosamente.');
    }

    public function updatingFiltroNombre()
    {
        $this->resetPage();
    }

    public function updatingFiltroApellido()
    {
        $this->resetPage();
    }

    public function updatingFiltroEmail()
    {
        $this->resetPage();
    }

    public function updatingFiltroRol()
    {
        $this->resetPage();
    }

    public function updatingFiltroEscuela()
    {
        $this->resetPage();
    }

    public function updatingFiltroEstado()
    {
        $this->resetPage();
    }

    public function updatingFiltroVerificado()
    {
        $this->resetPage();
    }
}